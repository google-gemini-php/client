<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Chunk from context retrieved by the file search tool.
 *
 * https://ai.google.dev/api/generate-content#RetrievedContext
 */
final class RetrievedContext implements Arrayable
{
    /**
     * @param  ?string  $uri  URI reference of the semantic retrieval document.
     * @param  ?string  $title  Title of the document.
     * @param  ?string  $text  Text of the chunk.
     * @param  ?string  $fileSearchStore  Name of the FileSearchStore containing the document. Example: fileSearchStores/123.
     */
    public function __construct(
        public readonly ?string $uri,
        public readonly ?string $title,
        public readonly ?string $text,
        public readonly ?string $fileSearchStore,
    ) {}

    /**
     * @param  array{ uri: ?string, title: ?string, text: ?string, fileSearchStore: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            uri: $attributes['uri'] ?? null,
            title: $attributes['title'] ?? null,
            text: $attributes['text'] ?? null,
            fileSearchStore: $attributes['fileSearchStore'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uri' => $this->uri,
            'title' => $this->title,
            'text' => $this->text,
            'fileSearchStore' => $this->fileSearchStore,
        ];
    }
}
