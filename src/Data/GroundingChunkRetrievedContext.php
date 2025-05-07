<?php

declare(strict_types = 1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Chunk from context retrieved by the retrieval tools
 *
 * https://ai.google.dev/gemini-api/docs/grounding?configure-search&lang=rest#grounded-response
 */
final class GroundingChunkRetrievedContext implements Arrayable
{
    /**
     * @param string|null $text Text of the attribution
     * @param string|null $title Title of the attribution
     * @param string|null $uri URI reference of the attribution
     */
    public function __construct(
        public readonly ?string $text = null,
        public readonly ?string $title = null,
        public readonly ?string $uri = null,
    ) {
    }

    /**
     * @param array{ text: string, title: string, uri: string } $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            text: $attributes['text'] ?? null,
            title: $attributes['title'] ?? null,
            uri: $attributes['uri'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'text' => $this->text,
            'title' => $this->title,
            'uri' => $this->uri,
        ];
    }
}
