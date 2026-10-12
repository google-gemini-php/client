<?php

use Gemini\Data\LogprobsResult;

test('round trip', function () {
    $attributes = [
        'topCandidates' => [
            [
                'candidates' => [
                    ['token' => 'Hello', 'tokenId' => 1, 'logProbability' => -0.1],
                    ['token' => 'Hi', 'tokenId' => 2, 'logProbability' => -2.5],
                ],
            ],
        ],
        'chosenCandidates' => [
            ['token' => 'Hello', 'tokenId' => 1, 'logProbability' => -0.1],
        ],
    ];

    expect(LogprobsResult::from($attributes)->toArray())->toBe($attributes);
});
