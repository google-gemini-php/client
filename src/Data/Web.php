<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Chunk from the web.
 *
 * https://ai.google.dev/api/generate-content#Web
 */
final class Web implements Arrayable
{
    /**
     * @param  string  $uri  URI reference of the chunk.
     * @param  string  $title  Title of the chunk.
     */
    public function __construct(
        public readonly string $uri,
        public readonly string $title,
    ) {}

    /**
     * @param  array{ uri: string, title: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            uri: $attributes['uri'],
            title: $attributes['title'],
        );
    }

    public function toArray(): array
    {
        return [
            'uri' => $this->uri,
            'title' => $this->title,
        ];
    }
}
