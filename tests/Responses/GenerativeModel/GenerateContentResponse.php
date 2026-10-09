<?php

use Gemini\Data\Candidate;
use Gemini\Data\PromptFeedback;
use Gemini\Data\UsageMetadata;
use Gemini\Enums\FinishReason;
use Gemini\Enums\HarmCategory;
use Gemini\Enums\MimeType;
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

test('tts audio mime type', function () {
    $response = GenerateContentResponse::from([
        'candidates' => [
            [
                'content' => [
                    'parts' => [
                        ['inlineData' => ['mimeType' => 'audio/l16; rate=24000; channels=1', 'data' => 'aGVsbG8=']],
                    ],
                    'role' => 'model',
                ],
                'finishReason' => FinishReason::STOP->value,
            ],
        ],
        'usageMetadata' => [
            'promptTokenCount' => 0,
            'totalTokenCount' => 0,
        ],
    ]);

    expect($response->parts()[0]->inlineData)
        ->mimeType->toBe(MimeType::AUDIO_L16_RATE_24000_CHANNELS_1)
        ->toArray()->toBe([
            'mimeType' => 'audio/l16; rate=24000; channels=1',
            'data' => 'aGVsbG8=',
        ]);
});

test('new finish reasons', function () {
    foreach (['MISSING_THOUGHT_SIGNATURE', 'MALFORMED_RESPONSE', 'ESCALATION', 'PUP_LIMITED_DISABLED'] as $finishReason) {
        $response = GenerateContentResponse::from([
            'candidates' => [
                [
                    'finishReason' => $finishReason,
                    'index' => 0,
                ],
            ],
            'usageMetadata' => [
                'promptTokenCount' => 0,
                'totalTokenCount' => 0,
            ],
        ]);

        expect($response->candidates[0]->finishReason)->toBe(FinishReason::from($finishReason));
    }
});

test('jailbreak safety rating', function () {
    $response = GenerateContentResponse::from([
        'candidates' => [
            [
                'finishReason' => FinishReason::SAFETY->value,
                'safetyRatings' => [
                    ['category' => 'HARM_CATEGORY_JAILBREAK', 'probability' => 'HIGH', 'blocked' => true],
                ],
                'index' => 0,
            ],
        ],
        'usageMetadata' => [
            'promptTokenCount' => 0,
            'totalTokenCount' => 0,
        ],
    ]);

    expect($response->candidates[0]->safetyRatings[0])
        ->category->toBe(HarmCategory::HARM_CATEGORY_JAILBREAK)
        ->blocked->toBeTrue();
});
