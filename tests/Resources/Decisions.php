<?php

use Gemini\Data\Decisions\ChoiceQuestion;
use Gemini\Data\Decisions\NoulQuestion;
use Gemini\Enums\Method;
use Gemini\Responses\Decisions\DecisionsResponse;

it('creates decisions', function () {
    $client = mockClient(method: Method::POST, endpoint: 'decisions', response: DecisionsResponse::fake());

    $result = $client->decisions()->create(
        input: 'Test input context',
        questions: [
            'is_damaged' => NoulQuestion::make('Is the item damaged?'),
            'queue' => ChoiceQuestion::make('Which queue?', ['billing' => 'Billing', 'shipping' => 'Shipping']),
        ],
    );

    expect($result)->toBeInstanceOf(DecisionsResponse::class)
        ->and($result->answer('is_damaged'))->not->toBeNull()
        ->and($result->answer('is_damaged')?->isYes())->toBeTrue()
        ->and($result->answer('route_queue')?->choice)->toBe('replacements');
});
