<?php

declare(strict_types=1);

namespace Gemini\Resources;

use Gemini\Contracts\Resources\FilesContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Enums\MimeType;
use Gemini\Requests\Files\DeleteRequest;
use Gemini\Requests\Files\ListRequest;
use Gemini\Requests\Files\MetadataGetRequest;
use Gemini\Requests\Files\UploadRequest;
use Gemini\Responses\Files\ListResponse;
use Gemini\Responses\Files\MetadataResponse;
use Gemini\Responses\Files\UploadResponse;
use Gemini\Transporters\DTOs\ResponseDTO;

final class Files implements FilesContract
{
    public function __construct(
        private readonly TransporterContract $transporter,
    ) {}

    public function upload(
        string $filename,
        ?MimeType $mimeType = null,
        ?string $displayName = null
    ): MetadataResponse {
        $mimeType ??= MimeType::from((string) mime_content_type($filename));
        $displayName ??= $filename;
        /** @var ResponseDTO<array{ file: array{ name: string, displayName: string, mimeType: string, sizeBytes: string, createTime: string, updateTime: string, expirationTime: string, sha256Hash: string, uri: string, state: string, videoMetadata: ?array{ videoDuration: string } } }> $response */
        $response = $this->transporter->request(new UploadRequest($filename, $displayName, $mimeType));

        return UploadResponse::from($response->data())->file;
    }

    public function metadataGet(string $nameOrUri): MetadataResponse
    {
        /** @var ResponseDTO<array{ name: string, displayName: string, mimeType: string, sizeBytes: string, createTime: string, updateTime: string, expirationTime: string, sha256Hash: string, uri: string, state: string, videoMetadata: ?array{ videoDuration: string } }> $response */
        $response = $this->transporter->request(new MetadataGetRequest($nameOrUri));

        return MetadataResponse::from($response->data());
    }

    public function list(?int $pageSize = null, ?string $nextPageToken = null): ListResponse
    {
        /** @var ResponseDTO<array{ files: array{ array{ name: string, displayName: string, mimeType: string, sizeBytes: string, createTime: string, updateTime: string, expirationTime: string, sha256Hash: string, uri: string, state: string, videoMetadata: ?array{ videoDuration: string } } }, nextPageToken: string }> $response */
        $response = $this->transporter->request(new ListRequest(pageSize: $pageSize, nextPageToken: $nextPageToken));

        return ListResponse::from($response->data());
    }

    public function delete(string $nameOrUri): void
    {
        /** returns ResponseDTO<array{ }> */
        $this->transporter->request(new DeleteRequest($nameOrUri));
    }
}
