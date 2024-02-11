<?php

declare(strict_types=1);

use Gemini\Responses\GenerativeModel\CountTokensResponse;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Testing\ClientFake;

it('records a count tokens request', function () {
    $fake = new ClientFake([
        CountTokensResponse::fake(),
    ]);

    $fake->geminiPro()->countTokens('Hello');

    $fake->geminiPro()->assertSent(function (string $method, array $parameters) {
        return $method === 'countTokens' &&
            $parameters[0] === 'Hello';
    });
});

it('records a generate content request', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fake(),
    ]);

    $fake->geminiPro()->generateContent('Hello');

    $fake->geminiPro()->assertSent(function (string $method, array $parameters) {
        return $method === 'generateContent' &&
            $parameters[0] === 'Hello';
    });
});

it('records a stream generate content request', function () {
    $fake = new ClientFake([
        GenerateContentResponse::fakeStream(),
    ]);

    $fake->geminiPro()->streamGenerateContent('Hello');

    $fake->geminiPro()->assertSent(function (string $method, array $parameters) {
        return $method === 'streamGenerateContent' &&
            $parameters[0] === 'Hello';
    });
});
