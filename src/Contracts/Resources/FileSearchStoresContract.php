<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use Gemini\Enums\MimeType;
use Gemini\Responses\FileSearchStores\Documents\DocumentResponse;
use Gemini\Responses\FileSearchStores\Documents\ListResponse as DocumentListResponse;
use Gemini\Responses\FileSearchStores\FileSearchStoreResponse;
use Gemini\Responses\FileSearchStores\ListResponse;
use Gemini\Responses\FileSearchStores\UploadResponse;

interface FileSearchStoresContract
{
    /**
     * Create a file search store.
     *
     * @see https://ai.google.dev/api/file-search/file-search-stores#method:-fileSearchStores.create
     */
    public function create(?string $displayName = null): FileSearchStoreResponse;

    /**
     * Get a file search store.
     *
     * @see https://ai.google.dev/api/file-search/file-search-stores#method:-fileSearchStores.get
     */
    public function get(string $name): FileSearchStoreResponse;

    /**
     * List file search stores.
     *
     * @see https://ai.google.dev/api/file-search/file-search-stores#method:-fileSearchStores.list
     */
    public function list(?int $pageSize = null, ?string $nextPageToken = null): ListResponse;

    /**
     * Delete a file search store.
     *
     * @see https://ai.google.dev/api/file-search/file-search-stores#method:-fileSearchStores.delete
     */
    public function delete(string $name, bool $force = false): void;

    /**
     * Upload a file to a file search store.
     *
     * @param  array<string, string|int|float|array<string>>  $customMetadata
     *
     * @see https://ai.google.dev/api/file-search/file-search-stores#method:-media.uploadtofilesearchstore
     */
    public function upload(string $storeName, string $filename, ?MimeType $mimeType = null, ?string $displayName = null, array $customMetadata = []): UploadResponse;

    /**
     * List documents in a file search store.
     *
     * @see https://ai.google.dev/api/file-search/documents#method:-fileSearchStores.documents.list
     */
    public function listDocuments(string $storeName, ?int $pageSize = null, ?string $nextPageToken = null): DocumentListResponse;

    /**
     * Get a document.
     *
     * @see https://ai.google.dev/api/file-search/documents#method:-fileSearchStores.documents.get
     */
    public function getDocument(string $name): DocumentResponse;

    /**
     * Delete a document.
     *
     * @see https://ai.google.dev/api/file-search/documents#method:-fileSearchStores.documents.delete
     */
    public function deleteDocument(string $name, bool $force = false): void;
}
