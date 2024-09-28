<?php

declare(strict_types=1);

namespace Gemini\Testing\Responses\Fixtures\Models;

final class RetrieveModelResponseFixture
{
    public const ATTRIBUTES = [
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
        'maxTemperature' => 2.0,
        'topP' => 1.0,
        'topK' => 1,
    ];
}
