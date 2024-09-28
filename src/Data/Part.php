<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * A datatype containing media that is part of a multi-part Content message.
 */
final class Part implements Arrayable
{
    /**
     * @param  string|null  $text  Inline text.
     * @param  Blob|null  $inlineData  Inline media bytes.
     */
    public function __construct(
        public readonly ?string $text = null,
        public readonly ?Blob $inlineData = null,
    ) {}

    /**
     * @param  array{ text: ?string, inlineData: ?array{ mimeType: string, data: string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            text: $attributes['text'] ?? null,
            inlineData: isset($attributes['inlineData']) ? Blob::from($attributes['inlineData']) : null
        );
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->text !== null) {
            $data['text'] = $this->text;
        }

        if ($this->inlineData !== null) {
            $data['inlineData'] = $this->inlineData;
        }

        return $data;
    }
}
