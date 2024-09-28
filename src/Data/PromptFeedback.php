<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\BlockReason;

/**
 * A set of the feedback metadata the prompt specified in GenerateContentRequest.content.
 *
 * https://ai.google.dev/api/rest/v1/GenerateContentResponse#promptfeedback
 */
final class PromptFeedback implements Arrayable
{
    /**
     * @param  ?BlockReason  $blockReason  If set, the prompt was blocked and no candidates are returned. Rephrase your prompt.
     * @param  array<SafetyRating>  $safetyRatings  Ratings for safety of the prompt. There is at most one rating per category.
     */
    public function __construct(
        public readonly array $safetyRatings,
        public readonly ?BlockReason $blockReason,
    ) {}

    /**
     * @param  array{ safetyRatings: array{ array{ category: string, probability: string, blocked: ?bool } }, blockReason: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        $safetyRatings = array_map(
            static fn (array $rating): SafetyRating => SafetyRating::from($rating),
            $attributes['safetyRatings'],
        );

        return new self(
            safetyRatings: $safetyRatings,
            blockReason: BlockReason::tryFrom($attributes['blockReason'] ?? '')
        );
    }

    public function toArray(): array
    {
        return [
            'blockReason' => $this->blockReason?->value,
            'safetyRatings' => array_map(
                static fn (SafetyRating $rating): array => $rating->toArray(),
                $this->safetyRatings
            ),
        ];
    }
}
