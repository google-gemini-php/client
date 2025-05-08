<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Content Part modality
 *
 * https://ai.google.dev/api/generate-content#Modality
 */
enum Modality: string
{
    /**
     * Unspecified modality.
     */
    case MODALITY_UNSPECIFIED = 'MODALITY_UNSPECIFIED';

    /**
     * Plain text.
     */
    case TEXT = 'TEXT';

    /**
     * Image.
     */
    case IMAGE = 'IMAGE';

    /**
     * Video.
     */
    case VIDEO = 'VIDEO';

    /**
     * Audio.
     */
    case AUDIO = 'AUDIO';

    /**
     * Document, e.g. PDF.
     */
    case DOCUMENT = 'DOCUMENT';
}
