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

    /**
     * @param  array<MetadataResponse>  $files  The list of Files.
     * @param  string|null  $nextPageToken  A token that can be sent as a pageToken into a subsequent files.list call.
     */
    public function __construct(
        public readonly array $files,
        public readonly ?string $nextPageToken = null,
    ) {}

    /**
     * @param  array{ files: ?array{ array{ name: string, displayName: string, mimeType: string, sizeBytes: string, createTime: string, updateTime: string, expirationTime: string, sha256Hash: string, uri: string, state: string, videoMetadata: ?array{ videoDuration: string } } }, nextPageToken: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            files: array_map(fn (array $file): MetadataResponse => MetadataResponse::from($file), $attributes['files'] ?? []),
            nextPageToken: $attributes['nextPageToken'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'files' => array_map(fn (MetadataResponse $file): array => $file->toArray(), $this->files),
            'nextPageToken' => $this->nextPageToken,
        ];
    }
}
