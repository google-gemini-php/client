<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\FinishReason;
use Gemini\Enums\Role;

/**
 * A response candidate generated from the model.
 *
 * https://ai.google.dev/api/generate-content#candidate
 */
final class Candidate implements Arrayable
{
    /**
     * @param  Content  $content  Output only. Generated content returned from the model.
     * @param  FinishReason|null  $finishReason  Optional. Output only. The reason why the model stopped generating tokens. If empty, the model has not stopped generating tokens.
     * @param  array<SafetyRating>  $safetyRatings  List of ratings for the safety of a response candidate. There is at most one rating per category.
     * @param  CitationMetadata  $citationMetadata  Output only. Citation information for model-generated candidate.
     * @param  int|null  $index  Output only. Index of the candidate in the list of response candidates.
     * @param  int|null  $tokenCount  Output only. Token count for this candidate.
     * @param  float|null  $avgLogprobs  Output only. Average log probability score of the candidate.
     * @param  array<GroundingAttribution>  $groundingAttributions  Output only. Attribution information for sources that contributed to a grounded answer. This field is populated for GenerateAnswer calls.
     * @param  GroundingMetadata|null  $groundingMetadata  Output only. Grounding metadata for the candidate. This field is populated for GenerateContent calls.
     * @param  LogprobsResult|null  $logprobsResult  Output only. Log-likelihood scores for the response tokens and top tokens.
     * @param  UrlRetrievalMetadata|null  $urlRetrievalMetadata  Output only. Metadata related to url context retrieval tool.
     */
    public function __construct(
        public readonly Content $content,
        public readonly ?FinishReason $finishReason,
        public readonly array $safetyRatings,
        public readonly CitationMetadata $citationMetadata,
        public readonly ?int $index = null,
        public readonly ?int $tokenCount = null,
        public readonly ?float $avgLogprobs = null,
        public readonly ?array $groundingAttributions = null,
        public readonly ?GroundingMetadata $groundingMetadata = null,
        public readonly ?LogprobsResult $logprobsResult = null,
        public readonly ?UrlRetrievalMetadata $urlRetrievalMetadata = null,
    ) {}

    /**
     * @param  array{ content: ?array{ parts: array{ array{ text: ?string, inlineData: ?array{ mimeType: string, data: string }, fileData: ?array{ fileUri: string, mimeType: string }, functionCall: ?array{ name: string, args: array<string, mixed>|null }, functionResponse: ?array{ name: string, response: array<string, mixed> } } }, role: string }, finishReason: ?string, safetyRatings: ?array{ array{ category: string, probability: string, blocked: ?bool } }, citationMetadata: ?array{ citationSources: array{ array{ startIndex: int, endIndex: int, uri: ?string, license: ?string} } }, index: ?int, tokenCount: ?int, avgLogprobs: ?float, groundingAttributions: ?array<array{ sourceId: array{ groundingPassage?: array{ passageId: string, partIndex: int }, semanticRetrieverChunk?: array{ source: string, chunk: string } }, content: array{ parts: array{ array{ text: ?string, inlineData: ?array{ mimeType: string, data: string }, fileData: ?array{ fileUri: string, mimeType: string }, functionCall: ?array{ name: string, args: array<string, mixed>|null }, functionResponse: ?array{ name: string, response: array<string, mixed> } } }, role: string } }>, groundingMetadata?: array{ groundingChunks: ?array<array{ web: null|array{ title: ?string, uri: ?string } }>, groundingSupports: ?array<array{ groundingChunkIndices: array<int>|null, confidenceScores: array<float>|null, segment: ?array{ partIndex: ?int, startIndex: ?int, endIndex: ?int, text: ?string } }>, webSearchQueries: ?array<string>, searchEntryPoint?: array{ renderedContent?: string|null, sdkBlob?: string|null }, retrievalMetadata: ?array{ googleSearchDynamicRetrievalScore?: float|null } }, logprobsResult?: array{ topCandidates: array<array{ candidates: array<array{ token: string, tokenId: int, logProbability: float }> }>, chosenCandidates: array<array{ token: string, tokenId: int, logProbability: float }> }, urlRetrievalMetadata?: array{ urlRetrievalContexts: array<array{ retrievedUrl: string }> } }  $attributes
     */
    public static function from(array $attributes): self
    {
        if (($attributes['avgLogprobs'] ?? null) === 'Infinity') { // @phpstan-ignore-line
            $attributes['avgLogprobs'] = INF;
        }

        return new self(
            content: isset($attributes['content']) ? Content::from($attributes['content']) : new Content(parts: [], role: Role::MODEL),
            finishReason: isset($attributes['finishReason']) ? FinishReason::from($attributes['finishReason']) : null,
            safetyRatings: array_map(
                static fn (array $rating): SafetyRating => SafetyRating::from($rating),
                $attributes['safetyRatings'] ?? [],
            ),
            citationMetadata: isset($attributes['citationMetadata']) ? CitationMetadata::from($attributes['citationMetadata']) : new CitationMetadata,
            index: $attributes['index'] ?? null,
            tokenCount: $attributes['tokenCount'] ?? null,
            avgLogprobs: $attributes['avgLogprobs'] ?? null,
            groundingAttributions: array_map(
                static fn (array $attribution): GroundingAttribution => GroundingAttribution::from($attribution),
                $attributes['groundingAttributions'] ?? []
            ),
            groundingMetadata: isset($attributes['groundingMetadata']) ? GroundingMetadata::from($attributes['groundingMetadata']) : null,
            logprobsResult: isset($attributes['logprobsResult']) ? LogprobsResult::from($attributes['logprobsResult']) : null,
            urlRetrievalMetadata: isset($attributes['urlRetrievalMetadata']) ? UrlRetrievalMetadata::from($attributes['urlRetrievalMetadata']) : null,
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
            'groundingAttributions' => array_map(
                static fn (GroundingAttribution $attribution): array => $attribution->toArray(),
                $this->groundingAttributions ?? []
            ),
            'groundingMetadata' => $this->groundingMetadata?->toArray(),
            'logprobsResult' => $this->logprobsResult?->toArray(),
            'urlRetrievalMetadata' => $this->urlRetrievalMetadata?->toArray(),
        ];
    }
}
