<?php

use Gemini\Data\Candidate;
use Gemini\Data\GenerationConfig;
use Gemini\Data\PromptFeedback;
use Gemini\Data\SafetySetting;
use Gemini\Data\UsageMetadata;
use Gemini\Enums\HarmBlockThreshold;
use Gemini\Enums\HarmCategory;
use Gemini\Enums\Method;
use Gemini\Enums\ModelType;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\CountTokensResponse;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Responses\StreamResponse;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

test('with safety setting', function () {
    $modelType = ModelType::GEMINI_PRO;
    $client = mockClient(method: Method::POST, endpoint: "{$modelType->value}:generateContent", response: GenerateContentResponse::fake(), times: 0);

    $firstSafetySetting = new SafetySetting(
        category: HarmCategory::HARM_CATEGORY_DANGEROUS_CONTENT,
        threshold: HarmBlockThreshold::BLOCK_ONLY_HIGH
    );

    $secondSafetySetting = new SafetySetting(
        category: HarmCategory::HARM_CATEGORY_HATE_SPEECH,
        threshold: HarmBlockThreshold::BLOCK_ONLY_HIGH
    );

    $generativeModel = $client
        ->generativeModel(model: $modelType)
        ->withSafetySetting($firstSafetySetting)
        ->withSafetySetting($secondSafetySetting);

    expect($generativeModel->safetySettings)
        ->{0}->toBe($firstSafetySetting)
        ->{1}->toBe($secondSafetySetting);
});

test('with generation config', function () {
    $modelType = ModelType::GEMINI_PRO;
    $client = mockClient(method: Method::POST, endpoint: "{$modelType->value}:generateContent", response: GenerateContentResponse::fake(), times: 0);

    $generationConfig = new GenerationConfig(
        stopSequences: [
            'Title',
        ],
        maxOutputTokens: 800,
        temperature: 1,
        topP: 0.8,
        topK: 10
    );

    $generativeModel = $client
        ->generativeModel(model: $modelType)
        ->withGenerationConfig($generationConfig);

    expect($generativeModel)
        ->generationConfig->toBe($generationConfig);
});

test('count tokens', function () {
    $modelType = ModelType::GEMINI_PRO;
    $client = mockClient(method: Method::POST, endpoint: "{$modelType->value}:countTokens", response: CountTokensResponse::fake());

    $result = $client->generativeModel(model: $modelType)->countTokens('Test');

    expect($result)
        ->toBeInstanceOf(CountTokensResponse::class)
        ->totalTokens->toBe(8);
});

test('count tokens for custom model', function () {
    $modelType = 'models/gemini-1.0-pro-001';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:countTokens", response: CountTokensResponse::fake());

    $result = $client->generativeModel(model: $modelType)->countTokens('Test');

    expect($result)
        ->toBeInstanceOf(CountTokensResponse::class)
        ->totalTokens->toBe(8);
});

test('generate content', function () {
    $modelType = ModelType::GEMINI_PRO;
    $client = mockClient(method: Method::POST, endpoint: "{$modelType->value}:generateContent", response: GenerateContentResponse::fake());

    $result = $client->geminiPro()->generateContent('Test');

    expect($result)
        ->toBeInstanceOf(GenerateContentResponse::class)
        ->candidates->toBeArray()->each->toBeInstanceOf(Candidate::class)
        ->promptFeedback->toBeInstanceOf(PromptFeedback::class)
        ->usageMetadata->toBeInstanceOf(UsageMetadata::class);
});

test('generate content for custom model', function () {
    $modelType = 'models/gemini-1.0-pro-001';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:generateContent", response: GenerateContentResponse::fake());

    $result = $client->generativeModel(model: $modelType)->generateContent('Test');

    expect($result)
        ->toBeInstanceOf(GenerateContentResponse::class)
        ->candidates->toBeArray()->each->toBeInstanceOf(Candidate::class)
        ->promptFeedback->toBeInstanceOf(PromptFeedback::class)
        ->usageMetadata->toBeInstanceOf(UsageMetadata::class);
});

test('stream generate content', function () {
    $response = new Response(
        body: new Stream(
            GenerateContentResponse::fakeResource()
        ),
    );

    $modelType = ModelType::GEMINI_PRO;
    $client = mockStreamClient(method: Method::POST, endpoint: "{$modelType->value}:streamGenerateContent", response: $response);

    $result = $client->geminiPro()->streamGenerateContent('Test');

    expect($result)
        ->toBeInstanceOf(StreamResponse::class)
        ->toBeInstanceOf(IteratorAggregate::class)
        ->and($result->getIterator())
        ->toBeInstanceOf(Iterator::class)
        ->and($result->getIterator()->current())
        ->toBeInstanceOf(GenerateContentResponse::class)
        ->candidates->toBeArray()->each->toBeInstanceOf(Candidate::class)
        ->promptFeedback->toBeInstanceOf(PromptFeedback::class)
        ->usageMetadata->toBeInstanceOf(UsageMetadata::class);

});

test('stream generate content for custom model', function () {
    $response = new Response(
        body: new Stream(
            GenerateContentResponse::fakeResource()
        ),
    );

    $modelType = 'models/gemini-1.0-pro-001';
    $client = mockStreamClient(method: Method::POST, endpoint: "{$modelType}:streamGenerateContent", response: $response);

    $result = $client->generativeModel(model: $modelType)->streamGenerateContent('Test');

    expect($result)
        ->toBeInstanceOf(StreamResponse::class)
        ->toBeInstanceOf(IteratorAggregate::class)
        ->and($result->getIterator())
        ->toBeInstanceOf(Iterator::class)
        ->and($result->getIterator()->current())
        ->toBeInstanceOf(GenerateContentResponse::class)
        ->candidates->toBeArray()->each->toBeInstanceOf(Candidate::class)
        ->promptFeedback->toBeInstanceOf(PromptFeedback::class)
        ->usageMetadata->toBeInstanceOf(UsageMetadata::class);
});

test('start chat', function () {
    $modelType = ModelType::GEMINI_PRO;
    $client = mockClient(method: Method::POST, endpoint: "{$modelType->value}:generateContent", response: GenerateContentResponse::fake(), times: 0);

    $result = $client->geminiPro()->startChat();

    expect($result)
        ->toBeInstanceOf(ChatSession::class);
});

test('start chat for custom model', function () {
    $modelType = 'models/gemini-1.0-pro-001';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:generateContent", response: GenerateContentResponse::fake(), times: 0);

    $result = $client->generativeModel(model: $modelType)->startChat();

    expect($result)
        ->toBeInstanceOf(ChatSession::class);
});
