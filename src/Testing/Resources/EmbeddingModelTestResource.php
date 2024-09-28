<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources;

use Gemini\Contracts\Resources\EmbeddingModalContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Enums\TaskType;
use Gemini\Requests\GenerativeModel\EmbedContentRequest;
use Gemini\Resources\EmbeddingModel;
use Gemini\Responses\GenerativeModel\BatchEmbedContentsResponse;
use Gemini\Responses\GenerativeModel\EmbedContentResponse;
use Gemini\Testing\Resources\Concerns\Testable;

final class EmbeddingModelTestResource implements EmbeddingModalContract
{
    use Testable;

    protected function resource(): string
    {
        return EmbeddingModel::class;
    }

    public function embedContent(Blob|Content|array|string $content, ?TaskType $taskType = null, ?string $title = null): EmbedContentResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args(), model: $this->model);
    }

    /**
     * Generates multiple embedding vectors from the input Content which consists of a batch of strings represented as EmbedContentRequest objects.
     *
     * @see https://ai.google.dev/api/embeddings#method:-models.batchembedcontents
     *
     * @param  string|Blob|array<string|Blob>|Content|EmbedContentRequest  ...$parts
     */
    public function batchEmbedContents(string|Blob|array|Content|EmbedContentRequest ...$parts): BatchEmbedContentsResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args(), model: $this->model);
    }
}
