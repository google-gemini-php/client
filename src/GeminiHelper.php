<?php

namespace Gemini;

use Gemini\Enums\ModelVariation;

class GeminiHelper
{
    /**
     * https://ai.google.dev/gemini-api/docs/models/gemini#model-variations
     */
    public static function generateGeminiModel(ModelVariation $variation, ?float $generation = null, ?string $version = null): string
    {
        $model = 'models/gemini';

        if ($generation != null) {
            $model .= '-'.number_format($generation, 1);
        }

        $model .= "-{$variation->value}";

        if ($version) {
            $model .= "-{$version}";
        }

        return $model;
    }
}
