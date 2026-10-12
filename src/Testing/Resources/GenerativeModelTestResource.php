<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources;

use Gemini\Contracts\Resources\GenerativeModelContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\SafetySetting;
use Gemini\Data\Tool;
use Gemini\Data\ToolConfig;
use Gemini\Data\UploadedFile;
use Gemini\Resources\ChatSession;
use Gemini\Resources\GenerativeModel;
use Gemini\Responses\GenerativeModel\CountTokensResponse;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Responses\StreamResponse;
use Gemini\Testing\Resources\Concerns\Testable;
use Gemini\Testing\Transporters\TestTransporter;
use LogicException;

final class GenerativeModelTestResource implements GenerativeModelContract
{
    use Testable;

    protected function resource(): string
    {
        return GenerativeModel::class;
    }

    public function countTokens(string|array|Blob|Content|UploadedFile ...$parts): CountTokensResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args(), model: $this->model);
    }

    public function generateContent(string|array|Blob|Content|UploadedFile ...$parts): GenerateContentResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args(), model: $this->model);
    }

    public function streamGenerateContent(string|array|Blob|Content|UploadedFile ...$parts): StreamResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args(), model: $this->model);
    }

    public function startChat(array $history = []): ChatSession
    {
        $this->recordFunctionCall(method: __FUNCTION__, args: func_get_args(), model: $this->model);

        return new ChatSession(
            model: new GenerativeModel(
                transporter: new TestTransporter(model: $this),
                model: $this->model ?? throw new LogicException('A model is required to start a chat.'),
            ),
            history: $history,
        );
    }

    public function withSystemInstruction(Content $systemInstruction): self
    {
        $this->recordFunctionCall(method: __FUNCTION__, args: func_get_args(), model: $this->model);

        return $this;
    }

    public function withSafetySetting(SafetySetting $safetySetting): self
    {
        $this->recordFunctionCall(method: __FUNCTION__, args: func_get_args(), model: $this->model);

        return $this;
    }

    public function withGenerationConfig(GenerationConfig $generationConfig): self
    {
        $this->recordFunctionCall(method: __FUNCTION__, args: func_get_args(), model: $this->model);

        return $this;
    }

    public function withTool(Tool $tool): self
    {
        $this->recordFunctionCall(method: __FUNCTION__, args: func_get_args(), model: $this->model);

        return $this;
    }

    public function withToolConfig(ToolConfig $toolConfig): self
    {
        $this->recordFunctionCall(method: __FUNCTION__, args: func_get_args(), model: $this->model);

        return $this;
    }

    public function withCachedContent(?string $cachedContent): self
    {
        $this->recordFunctionCall(method: __FUNCTION__, args: func_get_args(), model: $this->model);

        return $this;
    }
}
