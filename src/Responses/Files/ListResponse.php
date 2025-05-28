<?php

declare(strict_types=1);

namespace Gemini\Responses\Files;

use Gemini\Contracts\ResponseContract;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * @link https://ai.google.dev/api/files#File
 */
class ListResponse implements ResponseContract
{
    use Fakeable;

    public function __construct(
        public readonly array $files,
        public readonly string $nextPageToken,
    ) {}

    /**
     * @param  array{ files: array{ array{ name: string, displayName: string, mimeType: string, sizeBytes: string, createTime: string, updateTime: string, expirationTime: string, sha256Hash: string, uri: string, state: string, videoMetadata: ?array{ videoDuration: string } } }, nextPageToken: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            files: array_map([MetadataResponse::class, 'from'], $attributes['files']),
            nextPageToken: $attributes['nextPageToken'],
        );
    }

    public function toArray(): array
    {
        return [
            'files' => array_map(fn($file): array => $file->toArray(), $this->files),
            'nextPageToken' => $this->nextPageToken,
        ];
    }
}
