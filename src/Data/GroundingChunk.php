<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Grounding chunk.
 *
 * https://ai.google.dev/api/generate-content#GroundingChunk
 */
final class GroundingChunk implements Arrayable
{
    /**
     * @param  GroundingChunkRetrievedContext|null  $retrievedContext  Grounding chunk from context retrieved by the retrieval tools.
     * @param  Web|null  $web  Grounding chunk from the web.
     */
    public function __construct(
        public readonly ?GroundingChunkRetrievedContext $retrievedContext = null,
        public readonly ?Web $web = null,
    ) {}

    /**
     * @param  array{ retrievedContext: null|array{ text: ?string, title: ?string, uri: ?string }, web: null|array{ domain: ?string, title: ?string, uri: ?string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        $retrievedContext = match (true) {
            isset($attributes['retrievedContext']) => GroundingChunkRetrievedContext::from($attributes['retrievedContext']),
            default => null,
        };

        return new self(
            retrievedContext: $retrievedContext,
            web: isset($attributes['web']) ? Web::from($attributes['web']) : null,
        );
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->retrievedContext) {
            $data['retrievedContext'] = $this->retrievedContext->toArray();
        }

        if ($this->web !== null) {
            $data['web'] = $this->web->toArray();
        }

        return $data;
    }
}
