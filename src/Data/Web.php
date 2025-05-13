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
     * @param  ?string  $domain  Domain of the (original) URI
     * @param  ?string  $uri  URI reference of the chunk.
     * @param  ?string  $title  Title of the chunk.
     */
    public function __construct(
        public readonly ?string $domain,
        public readonly ?string $uri,
        public readonly ?string $title,
    ) {}

    /**
     * @param  array{ domain: ?string, title: ?string, uri: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            domain: $attributes['domain'] ?? null,
            uri: $attributes['uri'] ?? null,
            title: $attributes['title'] ?? null,
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
