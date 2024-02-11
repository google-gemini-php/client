<?php

declare(strict_types=1);

namespace Gemini\Resources;

use Gemini\Contracts\Resources\EmbeddingModalContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Enums\ModelType;
use Gemini\Enums\TaskType;
use Gemini\Requests\GenerativeModel\EmbedContentRequest;
use Gemini\Responses\GenerativeModel\EmbedContentResponse;
use Gemini\Transporters\DTOs\ResponseDTO;

final class EmbeddingModel implements EmbeddingModalContract
{
    public function __construct(
        private readonly TransporterContract $transporter,
        private readonly ModelType $model,
    ) {
    }

    /**
     *  Generates an embedding from the model given an input Content.
     *
     * @see https://ai.google.dev/api/rest/v1/models/embedContent
     *
     * @param  string|Blob|array<string|Blob>|Content  $content
     */
    public function embedContent(string|Blob|array|Content $content, ?TaskType $taskType = null, ?string $title = null): EmbedContentResponse
    {
        /** @var ResponseDTO<array{ embedding: array{ values: array<float> } }> $response */
        $response = $this->transporter->request(
            request: new EmbedContentRequest(
                model: $this->model,
                part: $content,
                taskType: $taskType,
                title: $title,
            )
        );

        return EmbedContentResponse::from($response->data());
    }
}
