<?php

use Gemini\Data\Candidate;
use Gemini\Data\PromptFeedback;
use Gemini\Data\UsageMetadata;
use Gemini\Enums\FinishReason;
use Gemini\Enums\ModelStage;
use Gemini\Enums\ServiceTier;
use Gemini\Enums\UrlRetrievalStatus;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;

test('from', function () {
    $fakeResponse = GenerateContentResponse::fake()->toArray();
    $response = GenerateContentResponse::from($fakeResponse);

    expect($response)
        ->toBeInstanceOf(GenerateContentResponse::class)
        ->candidates->each->toBeInstanceOf(Candidate::class)
        ->promptFeedback->toBeInstanceOf(PromptFeedback::class)
        ->usageMetadata->toBeInstanceOf(UsageMetadata::class);

});

test('response metadata fields', function () {
    $attributes = [
        'candidates' => [
            [
                'content' => [
                    'parts' => [['text' => 'Hello']],
                    'role' => 'model',
                ],
                'finishReason' => FinishReason::STOP->value,
                'finishMessage' => 'The model stopped generating tokens.',
                'urlContextMetadata' => [
                    'urlMetadata' => [
                        ['retrievedUrl' => 'https://example.com', 'urlRetrievalStatus' => 'URL_RETRIEVAL_STATUS_SUCCESS'],
                        ['retrievedUrl' => 'https://example.com/paywall', 'urlRetrievalStatus' => 'URL_RETRIEVAL_STATUS_PAYWALL'],
                    ],
                ],
                'index' => 0,
            ],
        ],
        'usageMetadata' => [
            'promptTokenCount' => 5,
            'candidatesTokenCount' => 1,
            'totalTokenCount' => 6,
            'serviceTier' => 'flex',
        ],
        'modelVersion' => 'gemini-2.5-flash',
        'responseId' => 'abc123',
        'modelStatus' => [
            'modelStage' => 'PREVIEW',
            'retirementTime' => '2026-12-31T00:00:00Z',
            'message' => 'This model will be retired soon.',
        ],
    ];

    $response = GenerateContentResponse::from($attributes);

    expect($response)
        ->responseId->toBe('abc123')
        ->modelStatus->modelStage->toBe(ModelStage::PREVIEW)
        ->modelStatus->retirementTime->toBe('2026-12-31T00:00:00Z')
        ->modelStatus->message->toBe('This model will be retired soon.')
        ->usageMetadata->serviceTier->toBe(ServiceTier::FLEX)
        ->candidates->{0}->finishMessage->toBe('The model stopped generating tokens.')
        ->candidates->{0}->urlContextMetadata->urlMetadata->toHaveCount(2)
        ->candidates->{0}->urlContextMetadata->urlMetadata->{0}->retrievedUrl->toBe('https://example.com')
        ->candidates->{0}->urlContextMetadata->urlMetadata->{0}->urlRetrievalStatus->toBe(UrlRetrievalStatus::URL_RETRIEVAL_STATUS_SUCCESS)
        ->candidates->{0}->urlContextMetadata->urlMetadata->{1}->urlRetrievalStatus->toBe(UrlRetrievalStatus::URL_RETRIEVAL_STATUS_PAYWALL);

    expect($response->toArray())
        ->responseId->toBe('abc123')
        ->modelStatus->toBe($attributes['modelStatus'])
        ->usageMetadata->serviceTier->toBe('flex')
        ->candidates->{0}->finishMessage->toBe('The model stopped generating tokens.')
        ->candidates->{0}->urlContextMetadata->toBe($attributes['candidates'][0]['urlContextMetadata']);
});

test('response metadata fields with unknown enum values', function () {
    $response = GenerateContentResponse::from([
        'candidates' => [
            [
                'urlContextMetadata' => [
                    'urlMetadata' => [
                        ['retrievedUrl' => 'https://example.com', 'urlRetrievalStatus' => 'SOME_NEW_STATUS'],
                    ],
                ],
            ],
        ],
        'usageMetadata' => [
            'promptTokenCount' => 0,
            'totalTokenCount' => 0,
            'serviceTier' => 'some-new-tier',
        ],
        'modelStatus' => [
            'modelStage' => 'SOME_NEW_STAGE',
        ],
    ]);

    expect($response)
        ->modelStatus->modelStage->toBeNull()
        ->usageMetadata->serviceTier->toBeNull()
        ->candidates->{0}->urlContextMetadata->urlMetadata->{0}->retrievedUrl->toBe('https://example.com')
        ->candidates->{0}->urlContextMetadata->urlMetadata->{0}->urlRetrievalStatus->toBeNull();
});

test('response metadata fields are optional', function () {
    $response = GenerateContentResponse::from([
        'candidates' => [
            [
                'finishReason' => FinishReason::STOP->value,
            ],
        ],
        'usageMetadata' => [
            'promptTokenCount' => 0,
            'totalTokenCount' => 0,
        ],
    ]);

    expect($response)
        ->responseId->toBeNull()
        ->modelStatus->toBeNull()
        ->usageMetadata->serviceTier->toBeNull()
        ->candidates->{0}->finishMessage->toBeNull()
        ->candidates->{0}->urlContextMetadata->toBeNull();
});

test('recitation finish reason', function () {
    $response = GenerateContentResponse::from([
        'candidates' => [
            [
                'finishReason' => FinishReason::RECITATION->value,
                'index' => 0,
            ],
        ],
        'usageMetadata' => [
            'promptTokenCount' => 0,
            'candidatesTokenCount' => 0,
            'totalTokenCount' => 0,
        ],
    ]);

    expect($response)
        ->toBeInstanceOf(GenerateContentResponse::class)
        ->candidates->each->toBeInstanceOf(Candidate::class)
        ->candidates->toHaveCount(1)
        ->candidates->{0}->content->parts->toBeEmpty()
        ->candidates->{0}->safetyRatings->toBeEmpty()
        ->candidates->{0}->citationMetadata->citationSources->toBeEmpty()
        ->candidates->{0}->index->toEqual(0)
        ->candidates->{0}->tokenCount->toBeNull()
        ->candidates->{0}->finishReason->toEqual(FinishReason::RECITATION)
        ->and(fn () => $response->text())
        ->toThrow(function (ValueError $e) {
            expect($e->getMessage())
                ->toBe('The `GenerateContentResponse::text()` quick accessor only works when the response contains a valid '.
                    '`Part`, but none was returned. Check the `candidate.safety_ratings` to see if the '.
                    'response was blocked.');
        });

});

test('fake', function () {
    $response = GenerateContentResponse::fake();

    expect($response)
        ->candidates->{0}
        ->finishReason->toBe(FinishReason::STOP);
});

test('to array', function () {
    $attributes = GenerateContentResponse::fake()->toArray();
    $response = GenerateContentResponse::from($attributes);

    expect($response->toArray())
        ->toBeArray()
        ->toBe($attributes);
});

test('fake with override', function () {
    $response = GenerateContentResponse::fake([
        'candidates' => [
            ['finishReason' => FinishReason::OTHER->value],
        ],
    ]);

    expect($response)
        ->candidates->{0}
        ->finishReason->toBe(FinishReason::OTHER);
});
