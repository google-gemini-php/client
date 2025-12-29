<?php

declare(strict_types=1);

namespace Gemini\Resources;

use Gemini\Contracts\Resources\FileSearchStoresContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Enums\MimeType;
use Gemini\Requests\FileSearchStores\CreateRequest;
use Gemini\Requests\FileSearchStores\DeleteRequest;
use Gemini\Requests\FileSearchStores\Documents\DeleteRequest as DeleteDocumentRequest;
use Gemini\Requests\FileSearchStores\Documents\GetRequest as GetDocumentRequest;
use Gemini\Requests\FileSearchStores\Documents\ListRequest as ListDocumentsRequest;
use Gemini\Requests\FileSearchStores\GetRequest;
use Gemini\Requests\FileSearchStores\ListRequest;
use Gemini\Requests\FileSearchStores\UploadRequest;
use Gemini\Responses\FileSearchStores\Documents\DocumentResponse;
use Gemini\Responses\FileSearchStores\Documents\ListResponse as DocumentListResponse;
use Gemini\Responses\FileSearchStores\FileSearchStoreResponse;
use Gemini\Responses\FileSearchStores\ListResponse;
use Gemini\Responses\FileSearchStores\UploadResponse;
use Gemini\Transporters\DTOs\ResponseDTO;

final class FileSearchStores implements FileSearchStoresContract
{
    public function __construct(
        private readonly TransporterContract $transporter,
    ) {}

    public function create(?string $displayName = null): FileSearchStoreResponse
    {
        /** @var ResponseDTO<array{ name: string, displayName?: string }> $response */
        $response = $this->transporter->request(new CreateRequest($displayName));

        return FileSearchStoreResponse::from($response->data());
    }

    public function get(string $name): FileSearchStoreResponse
    {
        /** @var ResponseDTO<array{ name: string, displayName?: string }> $response */
        $response = $this->transporter->request(new GetRequest($name));

        return FileSearchStoreResponse::from($response->data());
    }

    public function list(?int $pageSize = null, ?string $nextPageToken = null): ListResponse
    {
        /** @var ResponseDTO<array{ fileSearchStores: ?array<array{ name: string, displayName?: string }>, nextPageToken: ?string }> $response */
        $response = $this->transporter->request(new ListRequest(pageSize: $pageSize, nextPageToken: $nextPageToken));

        return ListResponse::from($response->data());
    }

    public function delete(string $name, bool $force = false): void
    {
        $this->transporter->request(new DeleteRequest($name, $force));
    }

    /**
     * @param  array<string, string|int|float|array<string>>  $customMetadata
     */
    public function upload(string $storeName, string $filename, ?MimeType $mimeType = null, ?string $displayName = null, array $customMetadata = []): UploadResponse
    {
        /** @var ResponseDTO<array{ name: string, metadata?: array<string, mixed>, done?: bool, response?: array<string, mixed>, error?: array<string, mixed> }> $response */
        $response = $this->transporter->request(new UploadRequest($storeName, $filename, $displayName, $mimeType, $customMetadata));

        return UploadResponse::from($response->data());
    }

    public function listDocuments(string $storeName, ?int $pageSize = null, ?string $nextPageToken = null): DocumentListResponse
    {
        /** @var ResponseDTO<array{ documents: ?array<array{ name: string, displayName?: string, customMetadata?: array<array{key: string, stringValue: string}>, updateTime?: string, createTime?: string }>, nextPageToken: ?string }> $response */
        $response = $this->transporter->request(new ListDocumentsRequest($storeName, $pageSize, $nextPageToken));

        return DocumentListResponse::from($response->data());
    }

    public function getDocument(string $name): DocumentResponse
    {
        /** @var ResponseDTO<array{ name: string, displayName?: string, customMetadata?: array<array{key: string, stringValue: string}>, updateTime?: string, createTime?: string }> $response */
        $response = $this->transporter->request(new GetDocumentRequest($name));

        return DocumentResponse::from($response->data());
    }

    public function deleteDocument(string $name, bool $force = false): void
    {
        $this->transporter->request(new DeleteDocumentRequest($name, $force));
    }
}
