<?php

declare(strict_types=1);

namespace Gemini\Resources;

use BackedEnum;
use Gemini\Concerns\HasModel;
use Gemini\Contracts\Resources\GenerativeModelContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\SafetySetting;
use Gemini\Data\Tool;
use Gemini\Data\ToolConfig;
use Gemini\Data\UploadedFile;
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
     * @param  array<array-key, Tool>  $tools
     */
    public function __construct(
        private readonly TransporterContract $transporter,
        BackedEnum|string $model,
        public array $safetySettings = [],
        public ?GenerationConfig $generationConfig = null,
        public ?Content $systemInstruction = null,
        public array $tools = [],
        public ?ToolConfig $toolConfig = null,
        public ?string $cachedContent = null,
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

    public function withSystemInstruction(Content $systemInstruction): self
    {
        $this->systemInstruction = $systemInstruction;

        return $this;
    }

    public function withTool(Tool $tool): self
    {
        $this->tools[] = $tool;

        return $this;
    }

    public function withToolConfig(ToolConfig $toolConfig): self
    {
        $this->toolConfig = $toolConfig;

        return $this;
    }

    public function withCachedContent(?string $cachedContent): self
    {
        $this->cachedContent = $cachedContent;

        return $this;
    }

    /**
     * Runs a model's tokenizer on input content and returns the token count.
     *
     * @see https://ai.google.dev/api/rest/v1beta/models/countTokens
     *
     * @param  string|Blob|array<string|Blob>|Content|UploadedFile  ...$parts
     *
     * @throws \Exception
     */
    public function countTokens(string|Blob|array|Content|UploadedFile ...$parts): CountTokensResponse
    {
        /** @var ResponseDTO<array{ totalTokens: int }> $response */
        $response = $this->transporter->request(request: new CountTokensRequest(model: $this->model, parts: $parts));

        return CountTokensResponse::from($response->data());
    }

    /**
     * Generates a response from the model given an input GenerateContentRequest.
     *
     * @see https://ai.google.dev/api/rest/v1beta/models/generateContent
     */
    public function generateContent(string|Blob|array|Content|UploadedFile ...$parts): GenerateContentResponse
    {
        /** @var ResponseDTO<array{ candidates: ?array<array{ content: ?array{ parts: array{ array{ text: ?string, inlineData: ?array{ mimeType: string, data: string }, fileData: ?array{ fileUri: string, mimeType: string }, functionCall: ?array{ name: string, args: array<string, mixed>|null }, functionResponse: ?array{ name: string, response: array<string, mixed> } } }, role: string }, finishReason: ?string, safetyRatings: ?array{ array{ category: string, probability: string, blocked: ?bool } }, citationMetadata: ?array{ citationSources: array{ array{ startIndex: int, endIndex: int, uri: ?string, license: ?string} } }, index: ?int, tokenCount: ?int, avgLogprobs: ?float, groundingAttributions: ?array<array{ sourceId: array{ groundingPassage?: array{ passageId: string, partIndex: int }, semanticRetrieverChunk?: array{ source: string, chunk: string } }, content: array{ parts: array{ array{ text: ?string, inlineData: ?array{ mimeType: string, data: string }, fileData: ?array{ fileUri: string, mimeType: string }, functionCall: ?array{ name: string, args: array<string, mixed>|null }, functionResponse: ?array{ name: string, response: array<string, mixed> } } }, role: string } }>, groundingMetadata?: array{ groundingChunks: ?array<array{ web: null|array{ title: ?string, uri: ?string } }>, groundingSupports: ?array<array{ groundingChunkIndices: array<int>|null, confidenceScores: array<float>|null, segment: ?array{ partIndex: ?int, startIndex: ?int, endIndex: ?int, text: ?string } }>, webSearchQueries: ?array<string>, searchEntryPoint?: array{ renderedContent?: string|null, sdkBlob?: string|null }, retrievalMetadata: ?array{ googleSearchDynamicRetrievalScore?: float|null } }, logprobsResult?: array{ topCandidates: array<array{ candidates: array<array{ token: string, tokenId: int, logProbability: float }> }>, chosenCandidates: array<array{ token: string, tokenId: int, logProbability: float }> }, urlRetrievalMetadata?: array{ urlRetrievalContexts: array<array{ retrievedUrl: string }> } }>, promptFeedback: ?array{ safetyRatings: array{ array{ category: string, probability: string, blocked: ?bool } }, blockReason: ?string }, usageMetadata: array{ promptTokenCount: int, totalTokenCount: int, candidatesTokenCount: ?int, cachedContentTokenCount: ?int, toolUsePromptTokenCount: ?int, thoughtsTokenCount: ?int, promptTokensDetails: list<array{ modality: string, tokenCount: int}>|null, cacheTokensDetails: list<array{ modality: string, tokenCount: int}>|null, candidatesTokensDetails: list<array{ modality: string, tokenCount: int}>|null, toolUsePromptTokensDetails: list<array{ modality: string, tokenCount: int}>|null }, modelVersion: ?string }> $response */
        $response = $this->transporter->request(
            request: new GenerateContentRequest(
                model: $this->model,
                parts: $parts,
                safetySettings: $this->safetySettings,
                generationConfig: $this->generationConfig,
                systemInstruction: $this->systemInstruction,
                tools: $this->tools,
                toolConfig: $this->toolConfig,
                cachedContent: $this->cachedContent,
            )
        );

        return GenerateContentResponse::from($response->data());
    }

    /**
     * Generates a streamed response from the model given an input GenerateContentRequest.
     *
     * @see https://ai.google.dev/api/rest/v1beta/models/streamGenerateContent
     */
    public function streamGenerateContent(string|Blob|array|Content|UploadedFile ...$parts): StreamResponse
    {
        $response = $this->transporter->requestStream(
            request: new StreamGenerateContentRequest(
                model: $this->model,
                parts: $parts,
                safetySettings: $this->safetySettings,
                generationConfig: $this->generationConfig,
                systemInstruction: $this->systemInstruction,
                tools: $this->tools,
                toolConfig: $this->toolConfig,
                cachedContent: $this->cachedContent,
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
