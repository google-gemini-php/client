<?php

use Gemini\Client;
use Gemini\Data\Candidate;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\PromptFeedback;
use Gemini\Data\SafetySetting;
use Gemini\Data\UploadedFile;
use Gemini\Data\UsageMetadata;
use Gemini\Enums\HarmBlockThreshold;
use Gemini\Enums\HarmCategory;
use Gemini\Enums\Method;
use Gemini\Enums\MimeType;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\CountTokensResponse;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Gemini\Responses\StreamResponse;
use Gemini\Transporters\DTOs\ResponseDTO;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

test('with safety setting', function () {
    $modelType = 'models/gemini-1.5-pro';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:generateContent", response: GenerateContentResponse::fake(), times: 0);

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
    $modelType = 'models/gemini-1.5-pro';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:generateContent", response: GenerateContentResponse::fake(), times: 0);

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
    $modelType = 'models/gemini-1.5-pro';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:countTokens", response: CountTokensResponse::fake());

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
    $modelType = 'models/gemini-1.5-pro';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:generateContent", response: GenerateContentResponse::fake());

    $result = $client->generativeModel($modelType)->generateContent('Test');

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

    $modelType = 'models/gemini-1.5-pro';
    $client = mockStreamClient(method: Method::POST, endpoint: "{$modelType}:streamGenerateContent", response: $response);

    $result = $client->generativeModel($modelType)->streamGenerateContent('Test');

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

test('generate content with uploaded file', function () {
    $modelType = 'models/gemini-1.5-pro';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:generateContent", response: GenerateContentResponse::fake());

    $result = $client->generativeModel($modelType)->generateContent(['Analyze file', new UploadedFile('123-456', MimeType::TEXT_PLAIN)]);

    expect($result)
        ->toBeInstanceOf(GenerateContentResponse::class)
        ->candidates->toBeArray()->each->toBeInstanceOf(Candidate::class)
        ->promptFeedback->toBeInstanceOf(PromptFeedback::class)
        ->usageMetadata->toBeInstanceOf(UsageMetadata::class);
});

test('start chat', function () {
    $modelType = 'models/gemini-1.5-pro';
    $client = mockClient(method: Method::POST, endpoint: "{$modelType}:generateContent", response: GenerateContentResponse::fake(), times: 0);

    $result = $client->generativeModel($modelType)->startChat();

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

test('generative model with system instruction', function () {
    $modelType = 'models/gemini-1.5-pro';
    $systemInstruction = 'You are a helpful assistant.';
    $userMessage = 'Hello';

    $mockTransporter = Mockery::mock(\Gemini\Contracts\TransporterContract::class);
    $mockTransporter->shouldReceive('request')
        ->once()
        ->andReturnUsing(function ($request) use (&$capturedRequest) {
            $capturedRequest = $request;

            return new ResponseDTO(GenerateContentResponse::fake()->toArray());
        });

    $client = new Client($mockTransporter);
    $model = $client->generativeModel(model: $modelType)
        ->withSystemInstruction(Content::parse($systemInstruction));

    $result = $model->generateContent($userMessage);

    expect($result)->toBeInstanceOf(GenerateContentResponse::class);

    expect($capturedRequest)
        ->toBeInstanceOf(\Gemini\Requests\GenerativeModel\GenerateContentRequest::class)
        ->and($capturedRequest->resolveEndpoint())->toBe("{$modelType}:generateContent");

    $body = $capturedRequest->body();

    expect($body)
        ->toHaveKey('contents')
        ->toHaveKey('systemInstruction')
        ->and($body['contents'][0]['parts'][0]['text'])->toBe($userMessage)
        ->and($body['systemInstruction']['parts'][0]['text'])->toBe($systemInstruction);

    expect($model)
        ->toHaveProperty('systemInstruction')
        ->and($model->systemInstruction)->toBeInstanceOf(Content::class)
        ->and($model->systemInstruction->parts[0]->text)->toBe($systemInstruction);
});

test('system instruction is included in the request', function () {
    $modelType = 'models/gemini-1.5-pro';
    $systemInstruction = 'You are a helpful assistant.';

    $mockTransporter = Mockery::mock(\Gemini\Contracts\TransporterContract::class);
    $mockTransporter->shouldReceive('request')
        ->once()
        ->withArgs(function (\Gemini\Requests\GenerativeModel\GenerateContentRequest $request) use ($systemInstruction) {
            $body = $request->body();

            return $body['contents'][0]['parts'][0]['text'] === 'Hello' &&
                $body['systemInstruction']['parts'][0]['text'] === $systemInstruction;
        })
        ->andReturn(new ResponseDTO(GenerateContentResponse::fake()->toArray()));

    $client = new \Gemini\Client($mockTransporter);

    $parsedSystemInstruction = Content::parse($systemInstruction);
    $generativeModel = $client->generativeModel(model: $modelType)
        ->withSystemInstruction($parsedSystemInstruction);

    $generativeModel->generateContent('Hello');
});
