<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources;

use Gemini\Contracts\Resources\FilesContract;
use Gemini\Enums\MimeType;
use Gemini\Resources\Files;
use Gemini\Responses\Files\ListResponse;
use Gemini\Responses\Files\MetadataResponse;
use Gemini\Testing\Resources\Concerns\Testable;

final class FilesTestResource implements FilesContract
{
    use Testable;

    protected function resource(): string
    {
        return Files::class;
    }

    public function upload(string $filename, ?MimeType $mimeType = null, ?string $displayName = null): MetadataResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function metadataGet(string $nameOrUri): MetadataResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function list(?int $pageSize = null, ?string $nextPageToken = null): ListResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args());
    }

    public function delete(string $nameOrUri): void
    {
        $this->record(method: __FUNCTION__, args: func_get_args());
    }
}
