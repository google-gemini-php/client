<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use Gemini\Enums\MimeType;
use Gemini\Responses\Files\ListResponse;
use Gemini\Responses\Files\MetadataResponse;

interface FilesContract
{
    /**
     * Uploads a media file to be reused across multiple requests and prompts.
     * Any omitted parameters will be derived from the file.
     */
    public function upload(string $filename, ?MimeType $mimeType = null, ?string $displayName = null): MetadataResponse;

    /**
     * Gets file upload metadata.
     *
     * @param  string  $nameOrUri  Either the just file name or the complete metadata URI from an upload.
     */
    public function metadataGet(string $nameOrUri): MetadataResponse;

    public function list(?int $pageSize = null, ?string $nextPageToken = null): ListResponse;

    public function delete(string $nameOrUri): void;
}
