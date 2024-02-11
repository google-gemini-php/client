<?php

use Gemini\Enums\Method;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;

test('send message', function () {
    $client = mockClient(method: Method::POST, endpoint: 'generateContent', response: GenerateContentResponse::fake(), times: 0);

    $result = $client->geminiPro()->startChat();

    expect($result)
        ->toBeInstanceOf(ChatSession::class);
});
