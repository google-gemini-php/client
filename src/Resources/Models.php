<?php

declare(strict_types=1);

namespace Gemini\Resources;

use Gemini\Concerns\HasModel;
use Gemini\Contracts\Resources\ModelContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Enums\ModelType;
use Gemini\Requests\Model\ListModelRequest;
use Gemini\Requests\Model\RetrieveModelRequest;
use Gemini\Responses\Models\ListModelResponse;
use Gemini\Responses\Models\RetrieveModelResponse;
use Gemini\Transporters\DTOs\ResponseDTO;

final class Models implements ModelContract
{
    use HasModel;

    /**
     * Creates an instance with the given Transporter
     */
    public function __construct(private readonly TransporterContract $transporter) {}

    /**
     * Lists available models.
     *
     * @see https://ai.google.dev/api/rest/v1/models/list
     *
     * @throws \JsonException
     */
    public function list(?int $pageSize = null, ?string $nextPageToken = null): ListModelResponse
    {
        /** @var ResponseDTO<array{ models: array{ array{ name: string, version: string, displayName: string, description: string, inputTokenLimit: int, outputTokenLimit: int, supportedGenerationMethods: array<string>, baseModelId: ?string, temperature: ?float, maxTemperature: ?float, topP: ?float, topK: ?int } }, nextPageToken: ?string }> $response */
        $response = $this->transporter->request(request: new ListModelRequest(pageSize: $pageSize, nextPageToken: $nextPageToken));

        return ListModelResponse::from(attributes: $response->data());
    }

    /**
     * Retrieves a model instance, providing basic information about the model such as the owner and permissioning.
     *
     * @see https://ai.google.dev/api/rest/v1/models/get
     */
    public function retrieve(ModelType|string $model): RetrieveModelResponse
    {
        /** @var ResponseDTO<array{ name: string, version: string, displayName: string, description: string, inputTokenLimit: int, outputTokenLimit: int, supportedGenerationMethods: array<string>, baseModelId: ?string, temperature: ?float, maxTemperature: ?float, topP: ?float, topK: ?int }> $response */
        $response = $this->transporter->request(request: new RetrieveModelRequest(model: $this->parseModel(model: $model)));

        return RetrieveModelResponse::from(attributes: $response->data());
    }
}
