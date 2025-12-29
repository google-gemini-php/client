<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources;

use Gemini\Contracts\Resources\FileSearchStoresContract;
use Gemini\Enums\MimeType;
use Gemini\Resources\FileSearchStores;
use Gemini\Responses\FileSearchStores\Documents\DocumentResponse;
use Gemini\Responses\FileSearchStores\Documents\ListResponse as DocumentListResponse;
use Gemini\Responses\FileSearchStores\FileSearchStoreResponse;
use Gemini\Responses\FileSearchStores\ListResponse;
use Gemini\Responses\FileSearchStores\UploadResponse;
use Gemini\Testing\Resources\Concerns\Testable;

final class FileSearchStoresTestResource implements FileSearchStoresContract
{
    use Testable;

    protected function resource(): string
    {
        return FileSearchStores::class;
    }

    public function create(?string $displayName = null): FileSearchStoreResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function get(string $name): FileSearchStoreResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function list(?int $pageSize = null, ?string $nextPageToken = null): ListResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function delete(string $name, bool $force = false): void
    {
        $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function upload(string $storeName, string $filename, ?MimeType $mimeType = null, ?string $displayName = null, array $customMetadata = []): UploadResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function listDocuments(string $storeName, ?int $pageSize = null, ?string $nextPageToken = null): DocumentListResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function getDocument(string $name): DocumentResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function deleteDocument(string $name, bool $force = false): void
    {
        $this->record(method: __FUNCTION__, args: func_get_args());
    }
}
