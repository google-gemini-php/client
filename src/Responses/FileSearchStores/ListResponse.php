<?php

declare(strict_types=1);

namespace Gemini\Responses\FileSearchStores;

use Gemini\Contracts\ResponseContract;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * @link https://ai.google.dev/api/file-search/file-search-stores#method:-fileSearchStores.list
 */
class ListResponse implements ResponseContract
{
    use Fakeable;

    /**
     * @param  array<FileSearchStoreResponse>  $fileSearchStores
     */
    public function __construct(
        public readonly array $fileSearchStores,
        public readonly ?string $nextPageToken = null,
    ) {}

    /**
     * @param  array{ fileSearchStores: ?array<array{ name: string, displayName?: string }>, nextPageToken: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            fileSearchStores: array_map(
                fn (array $store): FileSearchStoreResponse => FileSearchStoreResponse::from($store),
                $attributes['fileSearchStores'] ?? []
            ),
            nextPageToken: $attributes['nextPageToken'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'fileSearchStores' => array_map(
                fn (FileSearchStoreResponse $store): array => $store->toArray(),
                $this->fileSearchStores
            ),
            'nextPageToken' => $this->nextPageToken,
        ];
    }
}
