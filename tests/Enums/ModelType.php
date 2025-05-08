<?php

use Gemini\Data\Model;
use Gemini\Enums\ModelVariation;

test('generate gemini model', function () {
    expect(Model::generateGeminiModel(variation: ModelVariation::FLASH, generation: 1.5))
        ->toBe('models/gemini-1.5-flash')
        ->and(Model::generateGeminiModel(variation: ModelVariation::PRO, generation: 1.0))
        ->toBe('models/gemini-1.0-pro')
        ->and(Model::generateGeminiModel(variation: ModelVariation::PRO, generation: 1.0, version: 'latest'))
        ->toBe('models/gemini-1.0-pro-latest')
        ->and(Model::generateGeminiModel(variation: ModelVariation::FLASH, generation: 1.5, version: '001-tuning'))
        ->toBe('models/gemini-1.5-flash-001-tuning')
        ->and(Model::generateGeminiModel(variation: ModelVariation::PRO))
        ->toBe('models/gemini-pro');
});
