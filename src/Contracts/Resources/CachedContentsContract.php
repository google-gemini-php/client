<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use BackedEnum;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\Tool;
use Gemini\Data\ToolConfig;
use Gemini\Data\UploadedFile;
use Gemini\Responses\CachedContents\ListResponse;
use Gemini\Responses\CachedContents\MetadataResponse;

interface CachedContentsContract
{
    /**
     * @param  array<Tool>  $tools
     * @param  string|Blob|array<string|Blob|UploadedFile>|Content|UploadedFile  ...$parts
     */
    public function create(
        BackedEnum|string $model,
        ?Content $systemInstruction = null,
        array $tools = [],
        ?ToolConfig $toolConfig = null,
        ?string $ttl = null,
        ?string $displayName = null,
        string|Blob|array|Content|UploadedFile ...$parts,
    ): MetadataResponse;

    public function retrieve(string $name): MetadataResponse;

    public function list(?int $pageSize = null, ?string $pageToken = null): ListResponse;

    public function update(string $name, ?string $ttl = null, ?string $expireTime = null): MetadataResponse;

    public function delete(string $name): void;
}
