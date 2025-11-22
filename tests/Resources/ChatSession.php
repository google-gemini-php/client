<?php

use Gemini\Data\Candidate;
use Gemini\Data\PromptFeedback;
use Gemini\Data\UsageMetadata;
use Gemini\Enums\Method;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

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

test('stream send message', function () {
    $response = new Response(
        body: new Stream(
            GenerateContentResponse::fakeResource()
        ),
    );

    $modelType = 'models/gemini-1.5-flash';
    $client = mockStreamClient(method: Method::POST, endpoint: "{$modelType}:streamGenerateContent", response: $response);

    $chat = $client->generativeModel($modelType)->startChat();
    $result = $chat->streamSendMessage('Hello');

    expect($result)
        ->toBeInstanceOf(Generator::class)
        ->toBeInstanceOf(Iterator::class)
        ->and($result->current())
        ->toBeInstanceOf(GenerateContentResponse::class)
        ->candidates->toBeArray()->each->toBeInstanceOf(Candidate::class)
        ->promptFeedback->toBeInstanceOf(PromptFeedback::class)
        ->usageMetadata->toBeInstanceOf(UsageMetadata::class)
        ->and($chat->history)->toHaveCount(1);

});
