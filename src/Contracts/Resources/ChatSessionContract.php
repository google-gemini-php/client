<?php

declare(strict_types=1);

namespace Gemini\Contracts\Resources;

use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;

interface ChatSessionContract
{
    /**
     * @param  string|Blob|array<string|Blob>|Content  ...$parts
     */
    public function sendMessage(string|Blob|array|Content ...$parts): GenerateContentResponse;

    /**
     * @param  array<Content>  $history
     */
    public function startChat(array $history = []): ChatSessionContract;
}
