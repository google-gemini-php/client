<?php

use Gemini\Data\GroundingChunk;
use Gemini\Data\Map;
use Gemini\Data\PlaceAnswerSources;
use Gemini\Data\ReviewSnippet;

test('to array', function () {
    $reviewSnippet = new ReviewSnippet(
        title: 'Review Title',
        googleMapsUri: 'http://maps.google.com/review',
        reviewId: 'review-123'
    );

    $placeAnswerSources = new PlaceAnswerSources(
        reviewSnippets: [$reviewSnippet]
    );

    $map = new Map(
        uri: 'http://maps.google.com/place',
        title: 'Place Title',
        text: 'Place Description',
        placeId: 'place-123',
        placeAnswerSources: $placeAnswerSources
    );

    $groundingChunk = new GroundingChunk(
        map: $map
    );

    expect($groundingChunk->toArray())
        ->toEqual([
            'maps' => [
                'uri' => 'http://maps.google.com/place',
                'title' => 'Place Title',
                'text' => 'Place Description',
                'placeId' => 'place-123',
                'placeAnswerSources' => [
                    'reviewSnippets' => [
                        [
                            'title' => 'Review Title',
                            'googleMapsUri' => 'http://maps.google.com/review',
                            'reviewId' => 'review-123',
                        ],
                    ],
                ],
            ],
        ]);
});

test('from array', function () {
    $data = [
        'maps' => [
            'uri' => 'http://maps.google.com/place',
            'title' => 'Place Title',
            'text' => 'Place Description',
            'placeId' => 'place-123',
            'placeAnswerSources' => [
                'reviewSnippets' => [
                    [
                        'title' => 'Review Title',
                        'googleMapsUri' => 'http://maps.google.com/review',
                        'reviewId' => 'review-123',
                    ],
                ],
            ],
        ],
    ];

    $groundingChunk = GroundingChunk::from($data);

    expect($groundingChunk)->toBeInstanceOf(GroundingChunk::class)
        ->and($groundingChunk->map)->toBeInstanceOf(Map::class)
        ->and($groundingChunk->map->uri)->toBe('http://maps.google.com/place')
        ->and($groundingChunk->map->placeAnswerSources)->toBeInstanceOf(PlaceAnswerSources::class)
        ->and($groundingChunk->map->placeAnswerSources->reviewSnippets[0])->toBeInstanceOf(ReviewSnippet::class)
        ->and($groundingChunk->map->placeAnswerSources->reviewSnippets[0]->title)->toBe('Review Title');
});

test('from array with all fields', function () {
    $data = [
        'web' => [
            'uri' => 'http://google.com',
            'title' => 'Google',
        ],
        'retrievedContext' => [
            'uri' => 'http://example.com/doc',
            'title' => 'Doc Title',
            'text' => 'Doc Text',
            'fileSearchStore' => 'stores/123',
        ],
        'maps' => [
            'uri' => 'http://maps.google.com/place',
            'title' => 'Place Title',
        ],
    ];

    $groundingChunk = GroundingChunk::from($data);

    expect($groundingChunk->web->uri)->toBe('http://google.com')
        ->and($groundingChunk->retrievedContext->text)->toBe('Doc Text')
        ->and($groundingChunk->map->title)->toBe('Place Title');
});
