<?php

declare(strict_types=1);

namespace Gemini\Resources;

use Gemini\Concerns\HasModel;
use Gemini\Contracts\Resources\GenerativeModelContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\SafetySetting;
use Gemini\Enums\ModelType;
use Gemini\Requests\GenerativeModel\CountTokensRequest;
use Gemini\Requests\GenerativeModel\GenerateContentRequest;
use Gemini\Requests\GenerativeModel\StreamGenerateContentRequest;
use Gemini\Responses\GenerativeModel\CountTokensResponse;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Responses\StreamResponse;
use Gemini\Transporters\DTOs\ResponseDTO;

final class GenerativeModel implements GenerativeModelContract
{
    use HasModel;

    private readonly string $model;

    /**
     * @param  array<SafetySetting>  $safetySettings
     */
    public function __construct(
        private readonly TransporterContract $transporter,
        ModelType|string $model,
        public array $safetySettings = [],
        public ?GenerationConfig $generationConfig = null,
    ) {
        $this->model = $this->parseModel(model: $model);
    }

    public function withSafetySetting(SafetySetting $safetySetting): self
    {
        $this->safetySettings[] = $safetySetting;

        return $this;
    }

    public function withGenerationConfig(GenerationConfig $generationConfig): self
    {
        $this->generationConfig = $generationConfig;

        return $this;
    }

    /**
     * Runs a model's tokenizer on input content and returns the token count.
     *
     * @see https://ai.google.dev/api/rest/v1/models/countTokens
     *
     * @param  string|Blob|array<string|Blob>|Content  ...$parts
     *
     * @throws \Exception
     */
    public function countTokens(string|Blob|array|Content ...$parts): CountTokensResponse
    {
        /** @var ResponseDTO<array{ totalTokens: int }> $response */
        $response = $this->transporter->request(request: new CountTokensRequest(model: $this->model, parts: $parts));

        return CountTokensResponse::from($response->data());
    }

    /**
     * Generates a response from the model given an input GenerateContentRequest.
     *
     * @see https://ai.google.dev/api/rest/v1/models/generateContent
     */
    public function generateContent(string|Blob|array|Content ...$parts): GenerateContentResponse
    {
        /** @var ResponseDTO<array{ candidates: ?array{ array{ content: array{ parts: array{ array{ text: ?string, inlineData: array{ mimeType: string, data: string } } }, role: string }, finishReason: string, safetyRatings: array{ array{ category: string, probability: string, blocked: ?bool } }, citationMetadata: ?array{ citationSources: array{ array{ startIndex: int, endIndex: int, uri: ?string, license: ?string} } }, index: int, tokenCount: ?int, avgLogprobs: ?float } }, promptFeedback: ?array{ safetyRatings: array{ array{ category: string, probability: string, blocked: ?bool } }, blockReason: ?string }, usageMetadata: array{ promptTokenCount: int, candidatesTokenCount: int, totalTokenCount: int, cachedContentTokenCount: ?int }, usageMetadata: array{ promptTokenCount: int, candidatesTokenCount: int, totalTokenCount: int, cachedContentTokenCount: ?int } }> $response */
        $response = $this->transporter->request(
            request: new GenerateContentRequest(
                model: $this->model,
                parts: $parts,
                safetySettings: $this->safetySettings,
                generationConfig: $this->generationConfig,
            )
        );

        return GenerateContentResponse::from($response->data());
    }

    /**
     * Generates a streamed response from the model given an input GenerateContentRequest.
     *
     * @see https://ai.google.dev/api/rest/v1/models/streamGenerateContent
     */
    public function streamGenerateContent(string|Blob|array|Content ...$parts): StreamResponse
    {
        $response = $this->transporter->requestStream(
            request: new StreamGenerateContentRequest(
                model: $this->model,
                parts: $parts,
                safetySettings: $this->safetySettings,
                generationConfig: $this->generationConfig,
            )
        );

        return new StreamResponse(responseClass: GenerateContentResponse::class, response: $response);
    }

    /**
     * @param  array<Content>  $history
     */
    public function startChat(array $history = []): ChatSession
    {
        return new ChatSession(model: $this, history: $history);
    }
}
