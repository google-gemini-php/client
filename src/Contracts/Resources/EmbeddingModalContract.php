<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Enums\TaskType;
use Gemini\Responses\GenerativeModel\EmbedContentResponse;

interface EmbeddingModalContract
{
    /**
     * @param  string|Blob|array<string|Blob>|Content  $content
     */
    public function embedContent(string|Blob|array|Content $content, ?TaskType $taskType = null, ?string $title = null): EmbedContentResponse;
}
