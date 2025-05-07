<?php

declare(strict_types = 1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Grounding chunk
 *
 * https://ai.google.dev/gemini-api/docs/grounding?configure-search&lang=rest#grounded-response
 */
final class GroundingChunk implements Arrayable
{
    /**
     * @param GroundingChunkRetrievedContext|null $retrievedContext Grounding chunk from context retrieved by the retrieval tools
     * @param GroundingChunkWeb|null $web Grounding chunk from the web
     */
    public function __construct(
        public readonly ?GroundingChunkRetrievedContext $retrievedContext = null,
        public readonly ?GroundingChunkWeb $web = null
    ) {
    }

    /**
     * @param array{ retrievedContext: array, web: array } $attributes
     */
    public static function from(array $attributes): self
    {
        $retrievedContext = match(true) {
            isset($attributes['retrievedContext']) => GroundingChunkRetrievedContext::from($attributes['retrievedContext']),
            default => null,
        };

        $web = match(true) {
            isset($attributes['web']) => GroundingChunkWeb::from($attributes['web']),
            default => null,
        };

        return new self(
            retrievedContext: $retrievedContext,
            web: $web,
        );
    }

    public function toArray(): array
    {
        return [
            'retrievedContext' => $this->retrievedContext?->toArray(),
            'web' => $this->web?->toArray(),
        ];
    }
}
