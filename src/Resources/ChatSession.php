<?php

declare(strict_types=1);

namespace Gemini\Resources;

use Gemini\Concerns\HasContents;
use Gemini\Contracts\Resources\ChatSessionContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;

/**
 * https://ai.google.dev/tutorials/rest_quickstart#multi-turn_conversations_chat
 */
final class ChatSession implements ChatSessionContract
{
    use HasContents;

    /**
     * @param  GenerativeModel  $model  The model to use in the chat.
     * @param  array<Content>  $history  A chat history to initialize the object with.
     */
    public function __construct(
        public readonly GenerativeModel $model,
        public array $history = [],
    ) {}

    /**
     * @param  string|Blob|array<string|Blob>|Content  ...$parts
     */
    public function sendMessage(string|Blob|array|Content ...$parts): GenerateContentResponse
    {
        $this->history = array_merge($this->history, $this->partsToContents(...$parts));

        $response = $this->model->generateContent(...$this->history);

        if (! empty($response->candidates)) {
            $this->history[] = $response->candidates[0]->content;
        }

        return $response;
    }

    /**
     * @param  array<Content>  $history
     */
    public function startChat(array $history = []): ChatSession
    {
        return new self(model: $this->model, history: $history);
    }
}
