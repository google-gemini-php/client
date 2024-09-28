<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Fixtures\Models;

final class ListModelResponseFixture
{
    public const ATTRIBUTES = [
        'models' => [
            [
                'name' => 'models/gemini-pro',
                'version' => '001',
                'displayName' => 'Gemini Pro',
                'description' => 'The best model for scaling across a wide range of tasks',
                'inputTokenLimit' => 30720,
                'outputTokenLimit' => 2048,
                'supportedGenerationMethods' => [
                    'generateContent',
                    'countTokens',
                ],
                'temperature' => 0.9,
                'topP' => 1.0,
                'topK' => 1,
            ],
            [
                'name' => 'models/gemini-pro-vision',
                'version' => '001',
                'displayName' => 'Gemini Pro Vision',
                'description' => 'The best image understanding model to handle a broad range of applications',
                'inputTokenLimit' => 12288,
                'outputTokenLimit' => 4096,
                'supportedGenerationMethods' => [
                    'generateContent',
                    'countTokens',
                ],
                'temperature' => 0.4,
                'topP' => 1.0,
                'topK' => 32,
            ],
            [
                'name' => 'models/embedding-001',
                'version' => '001',
                'displayName' => 'Embedding 001',
                'description' => 'Obtain a distributed representation of a text.',
                'inputTokenLimit' => 2048,
                'outputTokenLimit' => 1,
                'supportedGenerationMethods' => [
                    'embedContent',
                    'countTextTokens',
                ],
            ],
        ],
        'nextPageToken' => null,
    ];
}
