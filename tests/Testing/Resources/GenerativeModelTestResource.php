<?php

declare(strict_types=1);

use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\SafetySetting;
use Gemini\Enums\HarmBlockThreshold;
use Gemini\Enums\HarmCategory;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\CountTokensResponse;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Testing\ClientFake;

it('records a count tokens request', function () {
    $fake = new ClientFake([
        CountTokensResponse::fake(),
    ]);

    $fake->generativeModel('models/gemini-1.5-pro')->countTokens('Hello');

    $fake->generativeModel('models/gemini-1.5-pro')->assertSent(function (string $method, array $parameters) {
        return $method === 'countTokens' &&
            $parameters[0] === 'Hello';
    });
});

it('records a generate content request', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->generativeModel('models/gemini-1.5-pro')->generateContent('Hello');

    $fake->generativeModel('models/gemini-1.5-pro')->assertSent(function (string $method, array $parameters) {
        return $method === 'generateContent' &&
            $parameters[0] === 'Hello';
    });
});

it('records a stream generate content request', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fakeStream(),
    ]);

    $fake->generativeModel('models/gemini-1.5-pro')->streamGenerateContent('Hello');

    $fake->generativeModel('models/gemini-1.5-pro')->assertSent(function (string $method, array $parameters) {
        return $method === 'streamGenerateContent' &&
            $parameters[0] === 'Hello';
    });
});

it('records a "withSafetySetting" function call', function () {
    $fake = new ClientFake;

    $safetySetting = new SafetySetting(HarmCategory::HARM_CATEGORY_DANGEROUS, HarmBlockThreshold::BLOCK_ONLY_HIGH);

    $fake->generativeModel('models/gemini-1.5-pro')->withSafetySetting($safetySetting);

    $fake->generativeModel('models/gemini-1.5-pro')->assertFunctionCalled(function (string $method, array $parameters) use ($safetySetting) {
        return $method === 'withSafetySetting' &&
            $parameters[0] === $safetySetting;
    });
});

it('records a "withGenerationConfig" function call', function () {
    $fake = new ClientFake;

    $generationConfig = new GenerationConfig;

    $fake->generativeModel('models/gemini-1.5-pro')->withGenerationConfig($generationConfig);

    $fake->generativeModel('models/gemini-1.5-pro')->assertFunctionCalled(function (string $method, array $parameters) use ($generationConfig) {
        return $method === 'withGenerationConfig' &&
            $parameters[0] === $generationConfig;
    });
});

it('records both content request and function call', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $generationConfig = new GenerationConfig;

    $fake->generativeModel('models/gemini-1.5-pro')->withGenerationConfig($generationConfig)->generateContent('Hello');

    $fake->generativeModel('models/gemini-1.5-pro')->assertSent(function (string $method, array $parameters) {
        return $method === 'generateContent' &&
            $parameters[0] === 'Hello';
    });
    $fake->generativeModel('models/gemini-1.5-pro')->assertFunctionCalled(function (string $method, array $parameters) use ($generationConfig) {
        return $method === 'withGenerationConfig' &&
            $parameters[0] === $generationConfig;
    });
});

it('records a "startChat" function call and the chat messages', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake([
            'candidates' => [['content' => ['parts' => [['text' => 'Hi there!']]]]],
        ]),
    ]);

    $chat = $fake->generativeModel('models/gemini-2.5-flash')->startChat(history: [Content::parse('Hello')]);
    $response = $chat->sendMessage('How are you?');

    expect($chat)->toBeInstanceOf(ChatSession::class)
        ->and($response->text())->toBe('Hi there!')
        ->and($chat->history)->toHaveCount(3);

    $fake->generativeModel('models/gemini-2.5-flash')->assertFunctionCalled(function (string $method, array $parameters) {
        return $method === 'startChat' &&
            $parameters[0][0]->parts[0]->text === 'Hello';
    });
    $fake->generativeModel('models/gemini-2.5-flash')->assertSent(function (string $method, array $parameters) {
        return $method === 'generateContent' &&
            count($parameters) === 2 &&
            $parameters[0]->parts[0]->text === 'Hello' &&
            $parameters[1]->parts[0]->text === 'How are you?';
    });
});

it('sends the whole chat history on every turn', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(['candidates' => [['content' => ['parts' => [['text' => 'First answer']]]]]]),
        GenerateContentResponse::fake(['candidates' => [['content' => ['parts' => [['text' => 'Second answer']]]]]]),
    ]);

    $chat = $fake->generativeModel('models/gemini-2.5-flash')->startChat();
    $chat->sendMessage('First question');
    $response = $chat->sendMessage('Second question');

    expect($response->text())->toBe('Second answer');

    $fake->generativeModel('models/gemini-2.5-flash')->assertSent(function (string $method, array $parameters) {
        return $method === 'generateContent' &&
            array_map(fn (Content $content): string => $content->role->value.': '.$content->parts[0]->text, $parameters) === [
                'user: First question',
                'model: First answer',
                'user: Second question',
            ];
    });
});

it('streams chat messages', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fakeStream(),
    ]);

    $chat = $fake->generativeModel('models/gemini-2.5-flash')->startChat();
    $chunks = iterator_to_array($chat->streamSendMessage('Tell me a story'), false);

    expect($chunks)->not->toBeEmpty()
        ->each->toBeInstanceOf(GenerateContentResponse::class)
        ->and($chat->history)->toHaveCount(2)
        ->and($chat->history[1]->parts[0]->text)->toStartWith('In the bustling city of Aethelwood');

    $fake->generativeModel('models/gemini-2.5-flash')->assertSent(function (string $method, array $parameters) {
        return $method === 'streamGenerateContent' &&
            $parameters[0]->parts[0]->text === 'Tell me a story';
    });
});
