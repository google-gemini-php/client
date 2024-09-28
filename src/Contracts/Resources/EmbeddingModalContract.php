<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Enums\TaskType;
use Gemini\Requests\GenerativeModel\EmbedContentRequest;
use Gemini\Responses\GenerativeModel\BatchEmbedContentsResponse;
use Gemini\Responses\GenerativeModel\EmbedContentResponse;

interface EmbeddingModalContract
{
    /**
     * @param  string|Blob|array<string|Blob>|Content  $content
     */
    public function embedContent(string|Blob|array|Content $content, ?TaskType $taskType = null, ?string $title = null): EmbedContentResponse;

    /**
     * Generates multiple embedding vectors from the input Content which consists of a batch of strings represented as EmbedContentRequest objects.
     *
     * @see https://ai.google.dev/api/embeddings#method:-models.batchembedcontents
     *
     * @param  string|Blob|array<string|Blob>|Content|EmbedContentRequest  ...$parts
     */
    public function batchEmbedContents(string|Blob|array|Content|EmbedContentRequest ...$parts): BatchEmbedContentsResponse;
}
