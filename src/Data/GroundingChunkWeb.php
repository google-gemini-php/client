<?php

declare(strict_types = 1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Chunk from the web
 *
 * https://ai.google.dev/gemini-api/docs/grounding?configure-search&lang=rest#grounded-response
 */
final class GroundingChunkWeb implements Arrayable
{
    /**
     * @param string|null $domain Domain of the (original) URI
     * @param string|null $title Title of the chunk
     * @param string|null $uri URI reference of the chunk
     */
    public function __construct(
        public readonly ?string $domain = null,
        public readonly ?string $title = null,
        public readonly ?string $uri = null,
    ) {
    }

    /**
     * @param array{ domain: string, title: string, uri: string } $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            domain: $attributes['domain'] ?? null,
            title: $attributes['title'] ?? null,
            uri: $attributes['uri'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'domain' => $this->domain,
            'uri' => $this->uri,
            'title' => $this->title,
        ];
    }
}
