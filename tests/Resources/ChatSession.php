<?php

use Gemini\Enums\Method;
use Gemini\Enums\ModelType;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;

test('send message', function () {
    $client = mockClient(method: Method::POST, endpoint: 'generateContent', response: GenerateContentResponse::fake(), times: 0);

    $result = $client->geminiPro()->startChat();

    expect($result)
        ->toBeInstanceOf(ChatSession::class);
});

test('start chat', function () {
    $modelType = ModelType::GEMINI_PRO;
    $client = mockClient(method: Method::POST, endpoint: "{$modelType->value}:generateContent", response: GenerateContentResponse::fake(), times: 0);

    $result = $client->chat()->startChat();

    expect($result)
        ->toBeInstanceOf(ChatSession::class);
});
