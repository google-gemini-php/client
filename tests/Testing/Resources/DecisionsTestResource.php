<?php

declare(strict_types=1);

use Gemini\Data\Decisions\ChoiceQuestion;
use Gemini\Data\Decisions\NoulQuestion;
use Gemini\Data\Decisions\ScoreQuestion;
use Gemini\Resources\Decisions;
use Gemini\Responses\Decisions\DecisionsResponse;
use Gemini\Testing\ClientFake;

it('records a create decision request', function () {
    $fake = new ClientFake([
        DecisionsResponse::fake(),
    ]);

    $questions = [
        'is_damaged' => NoulQuestion::make('Is it damaged?'),
        'route' => ChoiceQuestion::make('Route to where?', ['a' => 'A', 'b' => 'B']),
        'score' => ScoreQuestion::make('Rate from 1 to 3', [1 => 'Low', 2 => 'Med', 3 => 'High']),
    ];

    $response = $fake->decisions()->create('Some input context', $questions);

    $fake->assertSent(resource: Decisions::class, callback: function ($method, $parameters) use ($questions) {
        return $method === 'create' &&
            $parameters[0] === 'Some input context' &&
            $parameters[1] === $questions;
    });

    expect($response)->toBeInstanceOf(DecisionsResponse::class);
});
