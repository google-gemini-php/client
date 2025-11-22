<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources;

use Gemini\Contracts\Resources\ChatSessionContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\UploadedFile;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Testing\Resources\Concerns\Testable;
use Generator;

final class ChatSessionTestResource implements ChatSessionContract
{
    use Testable;

    protected function resource(): string
    {
        return ChatSession::class;
    }

    public function sendMessage(string|Blob|array|Content|UploadedFile ...$parts): GenerateContentResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args(), model: $this->model);
    }

    public function streamSendMessage(string|Blob|array|Content|UploadedFile ...$parts): Generator
    {
        yield $this->record(method: __FUNCTION__, args: func_get_args(), model: $this->model);
    }

    /**
     * @param  array<Content>  $history
     */
    public function startChat(array $history = []): ChatSessionTestResource
    {
        return $this->record(method: __FUNCTION__, args: func_get_args(), model: $this->model);
    }
}
