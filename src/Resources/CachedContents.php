<?php

declare(strict_types=1);

namespace Gemini\Resources;

use BackedEnum;
use Gemini\Concerns\HasModel;
use Gemini\Contracts\Resources\CachedContentsContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\Tool;
use Gemini\Data\ToolConfig;
use Gemini\Data\UploadedFile;
use Gemini\Requests\CachedContents\CreateRequest;
use Gemini\Requests\CachedContents\DeleteRequest;
use Gemini\Requests\CachedContents\ListRequest;
use Gemini\Requests\CachedContents\RetrieveRequest;
use Gemini\Requests\CachedContents\UpdateRequest;
use Gemini\Responses\CachedContents\ListResponse;
use Gemini\Responses\CachedContents\MetadataResponse;
use Gemini\Transporters\DTOs\ResponseDTO;

final class CachedContents implements CachedContentsContract
{
    use HasModel;

    public function __construct(private readonly TransporterContract $transporter) {}

    /**
     * @param  string|Blob|array<string|Blob|Content|UploadedFile>|Content|UploadedFile  ...$parts
     * @param  array<Tool>  $tools
     */
    public function create(
        BackedEnum|string $model,
        ?Content $systemInstruction = null,
        array $tools = [],
        ?ToolConfig $toolConfig = null,
        ?string $ttl = null,
        ?string $displayName = null,
        string|Blob|array|Content|UploadedFile ...$parts,
    ): MetadataResponse {
        /** @var array<int, string|Blob|array<string|Blob|UploadedFile>|Content|UploadedFile> $parts */
        /** @var ResponseDTO<array{name:string,model:string,displayName:string|null,usageMetadata:array<string,mixed>,createTime:string,updateTime:string,expireTime:string}> $response */
        $response = $this->transporter->request(new CreateRequest(
            model: $this->parseModel($model),
            systemInstruction: $systemInstruction,
            tools: $tools,
            toolConfig: $toolConfig,
            ttl: $ttl,
            displayName: $displayName,
            parts: array_values($parts),
        ));

        return MetadataResponse::from($response->data());
    }

    public function retrieve(string $name): MetadataResponse
    {
        /** @var ResponseDTO<array{name:string,model:string,displayName:string|null,usageMetadata:array<string,mixed>,createTime:string,updateTime:string,expireTime:string}> $response */
        $response = $this->transporter->request(new RetrieveRequest($name));

        return MetadataResponse::from($response->data());
    }

    public function list(?int $pageSize = null, ?string $pageToken = null): ListResponse
    {
        /** @var ResponseDTO<array{cachedContents:array<array<string,mixed>>|null,nextPageToken:string|null}> $response */
        $response = $this->transporter->request(new ListRequest($pageSize, $pageToken));

        return ListResponse::from($response->data());
    }

    public function update(string $name, ?string $ttl = null, ?string $expireTime = null): MetadataResponse
    {
        /** @var ResponseDTO<array{name:string,model:string,displayName:string|null,usageMetadata:array<string,mixed>,createTime:string,updateTime:string,expireTime:string}> $response */
        $response = $this->transporter->request(new UpdateRequest($name, $ttl, $expireTime));

        return MetadataResponse::from($response->data());
    }

    public function delete(string $name): void
    {
        $this->transporter->request(new DeleteRequest($name));
    }
}
