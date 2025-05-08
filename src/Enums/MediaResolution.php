<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Media resolution for the input media.
 *
 * https://ai.google.dev/api/generate-content#MediaResolution
 */
enum MediaResolution: string
{
    /**
     * Media resolution has not been set.
     */
    case MEDIA_RESOLUTION_UNSPECIFIED = 'MEDIA_RESOLUTION_UNSPECIFIED';

    /**
     * Media resolution set to low (64 tokens).
     */
    case MEDIA_RESOLUTION_LOW = 'MEDIA_RESOLUTION_LOW';

    /**
     * Media resolution set to medium (256 tokens).
     */
    case MEDIA_RESOLUTION_MEDIUM = 'MEDIA_RESOLUTION_MEDIUM';

    /**
     * Media resolution set to high (zoomed reframing with 256 tokens).
     */
    case MEDIA_RESOLUTION_HIGH = 'MEDIA_RESOLUTION_HIGH';
}
