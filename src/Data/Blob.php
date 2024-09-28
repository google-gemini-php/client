<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\MimeType;

/**
 * Raw media bytes.
 *
 * https://ai.google.dev/api/rest/v1/Content#blob
 */
final class Blob implements Arrayable
{
    /**
     * @param  MimeType  $mimeType  The IANA standard MIME type of the source data.
     * @param  string  $data  Raw bytes for media formats. A base64-encoded string.
     */
    public function __construct(
        public readonly MimeType $mimeType,
        public readonly string $data,
    ) {}

    /**
     * @param  array{ mimeType: string, data: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            mimeType: MimeType::from($attributes['mimeType']),
            data: $attributes['data']
        );
    }

    public function toArray(): array
    {
        return [
            'mimeType' => $this->mimeType->value,
            'data' => $this->data,
        ];
    }
}
