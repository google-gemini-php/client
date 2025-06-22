<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\SafetySetting;
use Gemini\Data\Tool;
use Gemini\Data\ToolConfig;
use Gemini\Data\UploadedFile;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\CountTokensResponse;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Responses\StreamResponse;

interface GenerativeModelContract
{
    /**
     * @param  string|Blob|array<string|Blob>|Content|UploadedFile  ...$parts
     */
    public function countTokens(string|Blob|array|Content|UploadedFile ...$parts): CountTokensResponse;

    /**
     * @param  string|Blob|array<string|Blob>|Content|UploadedFile  ...$parts
     */
    public function generateContent(string|Blob|array|Content|UploadedFile ...$parts): GenerateContentResponse;

    /**
     * @param  string|Blob|array<string|Blob>|Content|UploadedFile  ...$parts
     * @return StreamResponse<GenerateContentResponse>
     */
    public function streamGenerateContent(string|Blob|array|Content|UploadedFile ...$parts): StreamResponse;

    public function withSystemInstruction(Content $systemInstruction): self;

    /**
     * @param  array<Content>  $history
     */
    public function startChat(array $history = []): ChatSession;

    public function withSafetySetting(SafetySetting $safetySetting): self;

    public function withGenerationConfig(GenerationConfig $generationConfig): self;

    public function withTool(Tool $tool): self;

    public function withToolConfig(ToolConfig $toolConfig): self;

    public function withCachedContent(?string $cachedContent): self;
}
