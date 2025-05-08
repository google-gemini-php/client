<?php

declare(strict_types=1);

namespace Gemini\Enums;

use Gemini\Data\Model;

/**
 * @deprecated Will be removed in the next major version. We suggest implementing your own string backed enum for convenience.
 */
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
     * Alias of \Gemini\Data\Model::generateGeminiModel()
     */
    public static function generateGeminiModel(ModelVariation $variation, ?float $generation = null, ?string $version = null): string
    {
        return Model::generateGeminiModel($variation, $generation, $version);
    }
}
