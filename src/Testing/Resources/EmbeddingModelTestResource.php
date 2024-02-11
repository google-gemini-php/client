<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources;

use Gemini\Contracts\Resources\EmbeddingModalContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Enums\TaskType;
use Gemini\Resources\EmbeddingModel;
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
}
