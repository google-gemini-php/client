<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Supported modalities of the response.
 *
 * https://ai.google.dev/api/generate-content#Modality
 */
enum ResponseModality: string
{
    /**
     * Unspecified modality.
     */
    case MODALITY_UNSPECIFIED = 'MODALITY_UNSPECIFIED';

    /**
     * Indicates the model should return text.
     */
    case TEXT = 'TEXT';

    /**
     * Indicates the model should return images.
     */
    case IMAGE = 'IMAGE';

    /**
     * Indicates the model should return audio.
     */
    case AUDIO = 'AUDIO';
}
