<?php

declare(strict_types=1);

namespace Gemini\Responses\FileSearchStores;

use Gemini\Contracts\ResponseContract;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * @link https://ai.google.dev/api/file-search/file-search-stores#method:-media.uploadtofilesearchstore
 */
class UploadResponse implements ResponseContract
{
    use Fakeable;

    /**
     * @param  array<string, mixed>|null  $metadata
     * @param  array<string, mixed>|null  $response
     * @param  array<string, mixed>|null  $error
     */
    public function __construct(
        public readonly string $name,
        public readonly bool $done,
        public readonly ?array $metadata = null,
        public readonly ?array $response = null,
        public readonly ?array $error = null,
    ) {}

    /**
     * @param  array{ name: string, done?: bool, metadata?: array<string, mixed>, response?: array<string, mixed>, error?: array<string, mixed> }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            done: $attributes['done'] ?? (isset($attributes['response']) || isset($attributes['error'])),
            metadata: $attributes['metadata'] ?? null,
            response: $attributes['response'] ?? null,
            error: $attributes['error'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'done' => $this->done,
            'metadata' => $this->metadata,
            'response' => $this->response,
            'error' => $this->error,
        ];
    }
}
