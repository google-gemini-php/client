<?php

use Gemini\Enums\Method;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;

test('send message', function () {
    $client = mockClient(method: Method::POST, endpoint: 'generateContent', response: GenerateContentResponse::fake(), times: 0);

    $result = $client->generativeModel('models/gemini-1.5-flash')->startChat();

    expect($result)
        ->toBeInstanceOf(ChatSession::class);
});

test('start chat', function () {
    $client = mockClient(method: Method::POST, endpoint: 'models/gemini-1.5-flash:generateContent', response: GenerateContentResponse::fake(), times: 0);

    $result = $client->chat('models/gemini-1.5-flash')->startChat();

    expect($result)
        ->toBeInstanceOf(ChatSession::class);
});
