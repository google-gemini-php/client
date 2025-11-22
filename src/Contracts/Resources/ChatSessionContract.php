<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\UploadedFile;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Generator;

interface ChatSessionContract
{
    /**
     * @param  string|Blob|array<string|Blob>|Content  ...$parts
     */
    public function sendMessage(string|Blob|array|Content|UploadedFile ...$parts): GenerateContentResponse;

    /**
     * @param  string|Blob|array<string|Blob|UploadedFile>|Content|UploadedFile  ...$parts
     * @return \Generator<int, GenerateContentResponse>
     */
    public function streamSendMessage(string|Blob|array|Content|UploadedFile ...$parts): Generator;

    /**
     * @param  array<Content>  $history
     */
    public function startChat(array $history = []): ChatSessionContract;
}
