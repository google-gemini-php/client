<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * The tokenization quality used for the media of a single part.
 *
 * https://ai.google.dev/api/caching#MediaResolution
 */
enum PartMediaResolutionLevel: string
{
    /**
     * Media resolution has not been set.
     */
    case MEDIA_RESOLUTION_UNSPECIFIED = 'MEDIA_RESOLUTION_UNSPECIFIED';

    /**
     * Media resolution set to low.
     */
    case MEDIA_RESOLUTION_LOW = 'MEDIA_RESOLUTION_LOW';

    /**
     * Media resolution set to medium.
     */
    case MEDIA_RESOLUTION_MEDIUM = 'MEDIA_RESOLUTION_MEDIUM';

    /**
     * Media resolution set to high.
     */
    case MEDIA_RESOLUTION_HIGH = 'MEDIA_RESOLUTION_HIGH';

    /**
     * Media resolution set to ultra high.
     */
    case MEDIA_RESOLUTION_ULTRA_HIGH = 'MEDIA_RESOLUTION_ULTRA_HIGH';
}
