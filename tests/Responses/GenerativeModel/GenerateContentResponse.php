<?php

use Gemini\Data\Candidate;
use Gemini\Data\PromptFeedback;
use Gemini\Enums\FinishReason;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;

test('from', function () {
    $fakeResponse = GenerateContentResponse::fake()->toArray();
    $response = GenerateContentResponse::from($fakeResponse);

    expect($response)
        ->toBeInstanceOf(GenerateContentResponse::class)
        ->candidates->each->toBeInstanceOf(Candidate::class)
        ->promptFeedback->toBeInstanceOf(PromptFeedback::class);
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
