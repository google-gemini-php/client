<?php

use Gemini\Enums\ModelVariation;
use Gemini\GeminiHelper;

test('generate gemini model', function () {
    expect(GeminiHelper::generateGeminiModel(variation: ModelVariation::FLASH, generation: 1.5))
        ->toBe('models/gemini-1.5-flash')
        ->and(GeminiHelper::generateGeminiModel(variation: ModelVariation::PRO, generation: 1.0))
        ->toBe('models/gemini-1.0-pro')
        ->and(GeminiHelper::generateGeminiModel(variation: ModelVariation::PRO, generation: 1.0, version: 'latest'))
        ->toBe('models/gemini-1.0-pro-latest')
        ->and(GeminiHelper::generateGeminiModel(variation: ModelVariation::FLASH, generation: 1.5, version: '001-tuning'))
        ->toBe('models/gemini-1.5-flash-001-tuning')
        ->and(GeminiHelper::generateGeminiModel(variation: ModelVariation::PRO))
        ->toBe('models/gemini-pro');
});
