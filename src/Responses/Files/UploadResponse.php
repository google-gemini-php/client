<?php

declare(strict_types=1);

namespace Gemini\Responses\Files;

use Gemini\Contracts\ResponseContract;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * @link https://ai.google.dev/api/files#File
 */
class UploadResponse implements ResponseContract
{
    use Fakeable;

    public function __construct(
        public readonly MetadataResponse $file,
    ) {}

    /**
     * @param  array{ file: array{ name: string, displayName: string, mimeType: string, sizeBytes: string, createTime: string, updateTime: string, expirationTime: string, sha256Hash: string, uri: string, state: string, videoMetadata: ?array{ videoDuration: string } } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            file: MetadataResponse::from($attributes['file']),
        );
    }

    public function toArray(): array
    {
        return [
            'file' => $this->file->toArray(),
        ];
    }
}
