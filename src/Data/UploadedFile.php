<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\MimeType;

/**
 * URI based data.
 *
 * https://ai.google.dev/api/caching#FileData
 */
final class UploadedFile implements Arrayable
{
    /**
     * @param  string  $fileUri  Full URI to uploaded file.
     * @param  MimeType  $mimeType  The IANA standard MIME type of the source data.
     */
    public function __construct(
        public readonly string $fileUri,
        public readonly MimeType $mimeType,
    ) {}

    /**
     * @param  array{ fileUri: string, mimeType: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            fileUri: $attributes['fileUri'],
            mimeType: MimeType::from($attributes['mimeType']),
        );
    }

    public function toArray(): array
    {
        return [
            'fileUri' => $this->fileUri,
            'mimeType' => $this->mimeType->value,
        ];
    }
}
