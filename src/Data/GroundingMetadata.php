<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Metadata returned to client when grounding is enabled
 *
 * https://ai.google.dev/gemini-api/docs/grounding?configure-search&lang=rest#grounded-response
 */
final class GroundingMetadata implements Arrayable
{
    /**
     * @param array<GroundingChunk> $groundingChunks List of supporting references retrieved from specified grounding source
     * @param array<GroundingSupport> $groundingSupports List of grounding support
     * @param RetrievalMetadata|null $retrievalMetadata Retrieval metadata
     * @param array<string> $retrievalQueries Queries executed by the retrieval tools
     * @param SearchEntryPoint|null $searchEntryPoint Provided code for implementing Google Search Suggestions
     * @param array<string> $webSearchQueries Web search queries for the following-up web search
     */
    public function __construct(
        public readonly ?array $groundingChunks  = null,
        public readonly ?array $groundingSupports  = null,
        public readonly ?RetrievalMetadata $retrievalMetadata  = null,
        public readonly ?array $retrievalQueries  = null,
        public readonly ?SearchEntryPoint $searchEntryPoint = null,
        public readonly ?array $webSearchQueries  = null,
    ) {}

    /**
     * @param  array{
     *      groundingChunks: array,
     *      groundingSupports: array,
     *      retrievalMetadata: array,
     *      retrievalQueries: array<string>,
     *      searchEntryPoint: array,
     *      webSearchQueries: array<string>,
     * }  $attributes
     */
    public static function from(array $attributes): self
    {
        $groundingChunks = match(true) {
            isset($attributes['groundingChunks']) => array_map(
                static fn (array $groundingChunk): GroundingChunk => GroundingChunk::from($groundingChunk),
                $attributes['groundingChunks'],
            ),
            default => null,
        };
        $groundingSupports = match(true) {
            isset($attributes['groundingSupports']) => array_map(
                static fn (array $groundingSupport): GroundingSupport => GroundingSupport::from($groundingSupport),
                $attributes['groundingSupports'],
            ),
            default => null,
        };
        $retrievalMetadata = match(true) {
            isset($attributes['retrievalMetadata']) => RetrievalMetadata::from($attributes['retrievalMetadata']),
            default => null,
        };
        $searchEntryPoint = match(true) {
            isset($attributes['searchEntryPoint']) => SearchEntryPoint::from($attributes['searchEntryPoint']),
            default => null,
        };

        return new self(
            groundingChunks: $groundingChunks,
            groundingSupports: $groundingSupports,
            retrievalMetadata: $retrievalMetadata,
            retrievalQueries: $attributes['retrievalQueries'] ?? null,
            searchEntryPoint: $searchEntryPoint,
            webSearchQueries: $attributes['webSearchQueries'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'groundingChunks' => $this->groundingChunks ? array_map(
                fn ($groundingChunk): array => $groundingChunk->toArray(),
                $this->groundingChunks
            ) : null,
            'groundingSupports' => $this->groundingSupports ? array_map(
                fn ($groundingSupport): array => $groundingSupport->toArray(),
                $this->groundingSupports
            ) : null,
            'retrievalMetadata' => $this->retrievalMetadata?->toArray(),
            'retrievalQueries' => $this->retrievalQueries,
            'searchEntryPoint' => $this->searchEntryPoint?->toArray(),
            'webSearchQueries' => $this->webSearchQueries,
        ];
    }
}
