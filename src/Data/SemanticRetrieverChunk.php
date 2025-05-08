<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Identifier for a Chunk retrieved via Semantic Retriever specified in the GenerateAnswerRequest using SemanticRetrieverConfig.
 *
 * https://ai.google.dev/api/generate-content#SemanticRetrieverChunk
 */
final class SemanticRetrieverChunk implements Arrayable
{
    /**
     * @param  string  $source  Output only. Name of the source matching the request's SemanticRetrieverConfig.source. Example: corpora/123 or corpora/123/documents/abc
     * @param  string  $chunk  Output only. Name of the Chunk containing the attributed text. Example: corpora/123/documents/abc/chunks/xyz
     */
    public function __construct(
        public readonly string $source,
        public readonly string $chunk,
    ) {}

    /**
     * @param  array{ source: string, chunk: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            source: $attributes['source'],
            chunk: $attributes['chunk'],
        );
    }

    public function toArray(): array
    {
        return [
            'source' => $this->source,
            'chunk' => $this->chunk,
        ];
    }
}
