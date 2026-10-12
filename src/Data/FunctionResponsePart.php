<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * A datatype containing media that is part of a FunctionResponse message.
 *
 * https://ai.google.dev/api/caching#FunctionResponsePart
 */
final class FunctionResponsePart implements Arrayable
{
    /**
     * @param  Blob|null  $inlineData  Inline media bytes.
     */
    public function __construct(
        public readonly ?Blob $inlineData = null,
    ) {}

    /**
     * @param  array{ inlineData?: array{ mimeType: string, data: string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            inlineData: isset($attributes['inlineData']) ? Blob::from($attributes['inlineData']) : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'inlineData' => $this->inlineData?->toArray(),
        ], fn ($value) => $value !== null);
    }
}
