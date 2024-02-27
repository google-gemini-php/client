<?php

declare(strict_types=1);

namespace Gemini\Testing\Resources;

use Gemini\Contracts\Resources\ChatSessionContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Testing\Resources\Concerns\Testable;

final class ChatSessionTestResource implements ChatSessionContract
{
    use Testable;

    protected function resource(): string
    {
        return ChatSession::class;
    }

    public function sendMessage(string|array|Blob|Content ...$parts): GenerateContentResponse
    {
        return $this->record(method: __FUNCTION__, args: func_get_args(), model: $this->model);
    }

    /**
     * @param  array<Content>  $history
     */
    public function startChat(array $history = []): ChatSessionTestResource
    {
        return $this->record(method: __FUNCTION__, args: func_get_args(), model: $this->model);
    }
}
