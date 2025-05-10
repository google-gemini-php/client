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
     * @param  array<GroundingChunk>  $groundingChunks  List of supporting references retrieved from specified grounding source.
     * @param  array<GroundingSupport>  $groundingSupports  List of grounding support.
     * @param  array<string>  $webSearchQueries  Web search queries for the following-up web search.
     * @param  SearchEntryPoint|null  $searchEntryPoint  Optional. Google search entry for the following-up web searches.
     * @param  RetrievalMetadata  $retrievalMetadata  Metadata related to retrieval in the grounding flow.
     */
    public function __construct(
        public readonly array $groundingChunks,
        public readonly array $groundingSupports,
        public readonly array $webSearchQueries,
        public readonly ?SearchEntryPoint $searchEntryPoint,
        public readonly RetrievalMetadata $retrievalMetadata,
    ) {}

    /**
     * @param  array{ groundingChunks: array<array{ web?: array{ uri: string, title: string } }>, groundingSupports: array<array{ groundingChunkIndices: array<int>, confidenceScores: array<float>, segment: array{ partIndex: int, startIndex: int, endIndex: int, text: string } }>, webSearchQueries: array<string>, searchEntryPoint?: array{ renderedContent?: string|null, sdkBlob?: string|null }, retrievalMetadata: array{ googleSearchDynamicRetrievalScore?: float|null } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            groundingChunks: array_map(
                static fn (array $groundingChunk): GroundingChunk => GroundingChunk::from($groundingChunk),
                $attributes['groundingChunks'],
            ),
            groundingSupports: array_map(
                static fn (array $groundingSupport): GroundingSupport => GroundingSupport::from($groundingSupport),
                $attributes['groundingSupports'],
            ),
            webSearchQueries: $attributes['webSearchQueries'],
            searchEntryPoint: isset($attributes['searchEntryPoint']) ? SearchEntryPoint::from($attributes['searchEntryPoint']) : null,
            retrievalMetadata: RetrievalMetadata::from($attributes['retrievalMetadata']),
        );
    }

    public function toArray(): array
    {
        return [
            'groundingChunks' => array_map(
                static fn (GroundingChunk $groundingChunk): array => $groundingChunk->toArray(),
                $this->groundingChunks,
            ),
            'groundingSupports' => array_map(
                static fn (GroundingSupport $groundingSupport): array => $groundingSupport->toArray(),
                $this->groundingSupports,
            ),
            'webSearchQueries' => $this->webSearchQueries,
            'searchEntryPoint' => $this->searchEntryPoint?->toArray(),
            'retrievalMetadata' => $this->retrievalMetadata->toArray(),
        ];
    }
}
