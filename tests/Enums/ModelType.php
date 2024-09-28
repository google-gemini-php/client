<?php

use Gemini\Enums\ModelType;
use Gemini\Enums\ModelVariation;

test('generate gemini model', function () {
    expect(ModelType::generateGeminiModel(variation: ModelVariation::FLASH, generation: 1.5))
        ->toBe('models/gemini-1.5-flash')
        ->and(ModelType::generateGeminiModel(variation: ModelVariation::PRO, generation: 1.0))
        ->toBe('models/gemini-1.0-pro')
        ->and(ModelType::generateGeminiModel(variation: ModelVariation::PRO, generation: 1.0, version: 'latest'))
        ->toBe('models/gemini-1.0-pro-latest')
        ->and(ModelType::generateGeminiModel(variation: ModelVariation::FLASH, generation: 1.5, version: '001-tuning'))
        ->toBe('models/gemini-1.5-flash-001-tuning')
        ->and(ModelType::generateGeminiModel(variation: ModelVariation::PRO))
        ->toBe('models/gemini-pro');
});
