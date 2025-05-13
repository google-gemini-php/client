<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Metadata returned to client when grounding is enabled.
 *
 * https://ai.google.dev/api/generate-content#GroundingMetadata
 */
final class GroundingMetadata implements Arrayable
{
    /**
     * @param  array<GroundingChunk>|null  $groundingChunks  List of supporting references retrieved from specified grounding source.
     * @param  array<GroundingSupport>|null  $groundingSupports  List of grounding support.
     * @param  array<string>|null  $webSearchQueries  Web search queries for the following-up web search.
     * @param  SearchEntryPoint|null  $searchEntryPoint  Optional. Google search entry for the following-up web searches.
     * @param  RetrievalMetadata|null  $retrievalMetadata  Metadata related to retrieval in the grounding flow.
     */
    public function __construct(
        public readonly ?array $groundingChunks,
        public readonly ?array $groundingSupports,
        public readonly ?array $webSearchQueries,
        public readonly ?SearchEntryPoint $searchEntryPoint,
        public readonly ?RetrievalMetadata $retrievalMetadata,
    ) {}

    /**
     * @param  array{ groundingChunks: ?array<array{ web: null|array{ title: ?string, uri: ?string } }>, groundingSupports: ?array<array{ groundingChunkIndices: array<int>|null, confidenceScores: array<float>|null, segment: ?array{ partIndex: ?int, startIndex: ?int, endIndex: ?int, text: ?string } }>, webSearchQueries: ?array<string>, searchEntryPoint?: array{ renderedContent?: string|null, sdkBlob?: string|null }, retrievalMetadata: ?array{ googleSearchDynamicRetrievalScore?: float|null } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            groundingChunks: match (true) {
                isset($attributes['groundingChunks']) => array_map(
                    static fn (array $groundingChunk): GroundingChunk => GroundingChunk::from($groundingChunk),
                    $attributes['groundingChunks'],
                ),
                default => null
            },
            groundingSupports: match (true) {
                isset($attributes['groundingSupports']) => array_map(
                    static fn (array $groundingSupport): GroundingSupport => GroundingSupport::from($groundingSupport),
                    $attributes['groundingSupports'],
                ),
                default => null
            },
            webSearchQueries: $attributes['webSearchQueries'] ?? null,
            searchEntryPoint: isset($attributes['searchEntryPoint']) ? SearchEntryPoint::from($attributes['searchEntryPoint']) : null,
            retrievalMetadata: isset($attributes['retrievalMetadata']) ? RetrievalMetadata::from($attributes['retrievalMetadata']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'groundingChunks' => match (true) {
                isset($this->groundingChunks) => array_map(
                    static fn (GroundingChunk $groundingChunk): array => $groundingChunk->toArray(),
                    $this->groundingChunks,
                ),
                default => null
            },
            'groundingSupports' => match (true) {
                isset($this->groundingSupports) => array_map(
                    static fn (GroundingSupport $groundingSupport): array => $groundingSupport->toArray(),
                    $this->groundingSupports,
                ),
                default => null
            },
            'webSearchQueries' => $this->webSearchQueries,
            'searchEntryPoint' => $this->searchEntryPoint?->toArray(),
            'retrievalMetadata' => $this->retrievalMetadata?->toArray(),
        ];
    }
}
