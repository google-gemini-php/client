<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Fixtures\Decisions;

final class DecisionsResponseFixture
{
    public const ATTRIBUTES = [
        'answers' => [
            'is_damaged' => [
                'type' => 'noul',
                'noul' => 0.99,
                'probabilities' => [
                    'yes' => 0.99,
                    'no' => 0.01,
                ],
                'confidence' => 0.99,
            ],
            'route_queue' => [
                'type' => 'choice',
                'choice' => 'replacements',
                'probabilities' => [
                    'billing' => 0.01,
                    'replacements' => 0.95,
                    'general' => 0.04,
                ],
                'confidence' => 0.95,
            ],
            'urgency' => [
                'type' => 'score',
                'score' => 2.85,
                'legend' => [
                    '1' => 'Low urgency',
                    '2' => 'Moderate urgency',
                    '3' => 'Critical urgency',
                ],
                'probabilities' => [
                    '1' => 0.02,
                    '2' => 0.11,
                    '3' => 0.87,
                ],
                'confidence' => 0.87,
            ],
        ],
        'usage' => [
            'promptTokenCount' => 142,
            'totalTokenCount' => 142,
            'candidatesTokenCount' => 0,
        ],
    ];
}
