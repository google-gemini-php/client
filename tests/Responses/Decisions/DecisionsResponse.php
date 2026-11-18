<?php

use Gemini\Enums\DecisionQuestionType;
use Gemini\Responses\Decisions\DecisionsResponse;
use Gemini\Testing\Responses\Fixtures\Decisions\DecisionsResponseFixture;

it('builds from attributes and supports accessors', function () {
    $response = DecisionsResponse::from(DecisionsResponseFixture::ATTRIBUTES);

    expect($response->answers)->toHaveCount(3)
        ->and($response->answer('is_damaged'))->not->toBeNull()
        ->and($response->answer('is_damaged')?->type)->toBe(DecisionQuestionType::NOUL)
        ->and($response->answer('is_damaged')?->noul)->toBe(0.99)
        ->and($response->answer('is_damaged')?->confidence)->toBe(0.99)
        ->and($response->answer('is_damaged')?->isYes())->toBeTrue()
        ->and($response->answer('route_queue')?->type)->toBe(DecisionQuestionType::CHOICE)
        ->and($response->answer('route_queue')?->choice)->toBe('replacements')
        ->and($response->answer('route_queue')?->confidence)->toBe(0.95)
        ->and($response->answer('urgency')?->type)->toBe(DecisionQuestionType::SCORE)
        ->and($response->answer('urgency')?->score)->toBe(2.85)
        ->and($response->answer('urgency')?->confidence)->toBe(0.87)
        ->and($response->usageMetadata)->not->toBeNull()
        ->and($response->usageMetadata?->promptTokenCount)->toBe(142);
});

it('can fake and serialize to array', function () {
    $response = DecisionsResponse::fake();

    expect($response->toArray())->toHaveKey('answers')
        ->and($response->toArray()['answers'])->toHaveKey('is_damaged');
});
