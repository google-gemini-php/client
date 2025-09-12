<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources;

use BackedEnum;
use Gemini\Contracts\Resources\CachedContentsContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\ToolConfig;
use Gemini\Data\UploadedFile;
use Gemini\Responses\CachedContents\ListResponse;
use Gemini\Responses\CachedContents\MetadataResponse;
use Gemini\Testing\Resources\Concerns\Testable;

final class CachedContentsTestResource implements CachedContentsContract
{
    use Testable;

    protected function resource(): string
    {
        return \Gemini\Resources\CachedContents::class;
    }

    public function create(
        BackedEnum|string $model,
        ?Content $systemInstruction = null,
        array $tools = [],
        ?ToolConfig $toolConfig = null,
        ?string $ttl = null,
        ?string $displayName = null,
        string|Blob|array|Content|UploadedFile ...$parts,
    ): MetadataResponse {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function retrieve(string $name): MetadataResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function list(?int $pageSize = null, ?string $pageToken = null): ListResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function update(string $name, ?string $ttl = null, ?string $expireTime = null): MetadataResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function delete(string $name): void
    {
        $this->record(method: __FUNCTION__, args: func_get_args());
    }
}
