<?php

declare(strict_types=1);

namespace Gemini\Resources;

use Gemini\Concerns\HasContents;
use Gemini\Contracts\Resources\ChatSessionContract;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\Part;
use Gemini\Data\UploadedFile;
use Gemini\Enums\Role;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Generator;

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
     * @param  string|Blob|array<string|Blob|UploadedFile>|Content|UploadedFile  ...$parts
     */
    public function sendMessage(string|Blob|array|Content|UploadedFile ...$parts): GenerateContentResponse
    {
        $this->history = array_merge($this->history, $this->partsToContents(...$parts));

        $response = $this->model->generateContent(...$this->history);

        if (! empty($response->candidates)) {
            $this->history[] = $response->candidates[0]->content;
        }

        return $response;
    }

    /**
     * @param  string|Blob|array<string|Blob|UploadedFile>|Content|UploadedFile  ...$parts
     * @return Generator<int, GenerateContentResponse>
     */
    public function streamSendMessage(string|Blob|array|Content|UploadedFile ...$parts): Generator
    {
        $this->history = array_merge($this->history, $this->partsToContents(...$parts));

        $stream = $this->model->streamGenerateContent(...$this->history);

        /** @var array<Part> $parts */
        $parts = [];

        foreach ($stream as $response) {
            /** @var GenerateContentResponse $response */
            if (empty($response->candidates) === false) {
                foreach ($response->parts() as $part) {
                    $lastIndex = array_key_last($parts);
                    $last = $lastIndex === null ? null : $parts[$lastIndex];

                    // Streamed text arrives in chunks and is joined into one part. Any other part (function or
                    // tool calls, a switch between thoughts and answer) starts a new part, so it can be sent back as is.
                    $isTextContinuation = $last !== null
                        && $last->text !== null
                        && $part->text !== null
                        && $last->thought === $part->thought
                        && array_diff(array_keys($last->toArray()), ['text', 'thought']) === []
                        && array_diff(array_keys($part->toArray()), ['text', 'thought', 'thoughtSignature']) === [];

                    if ($isTextContinuation === false) {
                        $parts[] = $part;

                        continue;
                    }

                    $parts[$lastIndex] = Part::from(
                        attributes: array_merge( /* @phpstan-ignore argument.type */
                            $last->toArray(),
                            $part->toArray(),
                            ['text' => $last->text.$part->text]
                        )
                    );
                }
            }

            yield $response;
        }

        $this->history[] = new Content(
            parts: $parts,
            role: Role::MODEL,
        );
    }

    /**
     * @param  array<Content>  $history
     */
    public function startChat(array $history = []): ChatSession
    {
        return new self(model: $this->model, history: $history);
    }
}
