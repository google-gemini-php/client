<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\FinishReason;
use Gemini\Enums\Role;

/**
 * A response candidate generated from the model.
 *
 * https://ai.google.dev/api/rest/v1/GenerateContentResponse#candidate
 */
final class Candidate implements Arrayable
{
    /**
     * @param  Content  $content  Output only. Generated content returned from the model.
     * @param  FinishReason|null  $finishReason  The reason why the model stopped generating tokens.If empty, the model has not stopped generating the tokens.
     * @param  array<SafetyRating>  $safetyRatings  List of ratings for the safety of a response candidate. There is at most one rating per category.
     * @param  CitationMetadata  $citationMetadata  Output only. Citation information for model-generated candidate.
     * @param  int|null  $tokenCount  Output only. Token count for this candidate.
     * @param  int|null  $index  Output only. Index of the candidate in the list of candidates.
     */
    public function __construct(
        public readonly Content $content,
        public readonly ?FinishReason $finishReason,
        public readonly array $safetyRatings,
        public readonly CitationMetadata $citationMetadata,
        public readonly ?int $index,
        public readonly ?int $tokenCount,
        public readonly ?float $avgLogprobs,
    ) {}

    /**
     * @param  array{ content: ?array{ parts: array{ array{ text: ?string, inlineData: array{ mimeType: string, data: string } } }, role: string }, finishReason: ?string, safetyRatings: ?array{ array{ category: string, probability: string, blocked: ?bool } }, citationMetadata: ?array{ citationSources: array{ array{ startIndex: int, endIndex: int, uri: ?string, license: ?string} } }, index: ?int, tokenCount: ?int, avgLogprobs: ?float }  $attributes
     */
    public static function from(array $attributes): self
    {
        $safetyRatings = match (true) {
            isset($attributes['safetyRatings']) => array_map(
                static fn (array $rating): SafetyRating => SafetyRating::from($rating),
                $attributes['safetyRatings'],
            ),
            default => [],
        };

        $citationMetadata = match (true) {
            isset($attributes['citationMetadata']) => CitationMetadata::from($attributes['citationMetadata']),
            default => new CitationMetadata,
        };

        $content = match (true) {
            isset($attributes['content']) => Content::from($attributes['content']),
            default => new Content(parts: [], role: Role::MODEL),
        };

        $finishReason = match (true) {
            isset($attributes['finishReason']) => FinishReason::from($attributes['finishReason']),
            default => null,
        };

        return new self(
            content: $content,
            finishReason: $finishReason,
            safetyRatings: $safetyRatings,
            citationMetadata: $citationMetadata,
            index: $attributes['index'] ?? null,
            tokenCount: $attributes['tokenCount'] ?? null,
            avgLogprobs: $attributes['avgLogprobs'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content->toArray(),
            'finishReason' => $this->finishReason?->value,
            'safetyRatings' => array_map(
                static fn (SafetyRating $rating): array => $rating->toArray(),
                $this->safetyRatings
            ),
            'citationMetadata' => $this->citationMetadata->toArray(),
            'tokenCount' => $this->tokenCount,
            'index' => $this->index,
            'avgLogprobs' => $this->avgLogprobs,
        ];
    }
}
