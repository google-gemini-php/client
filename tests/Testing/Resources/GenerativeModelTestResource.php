<?php

declare(strict_types=1);

use Gemini\Data\GenerationConfig;
use Gemini\Data\SafetySetting;
use Gemini\Enums\HarmBlockThreshold;
use Gemini\Enums\HarmCategory;
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
