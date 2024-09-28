<?php

declare(strict_types=1);

namespace Gemini\Enums;

enum ModelType: string
{
    case GEMINI_PRO = 'models/gemini-pro';

    /**
     * https://ai.google.dev/gemini-api/docs/changelog#07-12-24
     *
     * @deprecated Use GEMINI_FLASH instead
     */
    case GEMINI_PRO_VISION = 'models/gemini-pro-vision';
    case GEMINI_FLASH = 'models/gemini-1.5-flash';
    case EMBEDDING = 'models/embedding-001';
    case TEXT_EMBEDDING = 'models/text-embedding-004';

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
