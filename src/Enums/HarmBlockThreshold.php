<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Block at and beyond a specified harm probability.
 *
 * https://ai.google.dev/api/generate-content#HarmBlockThreshold
 */
enum HarmBlockThreshold: string
{
    /**
     * Threshold is unspecified.
     */
    case HARM_BLOCK_THRESHOLD_UNSPECIFIED = 'HARM_BLOCK_THRESHOLD_UNSPECIFIED';

    /**
     * Content with NEGLIGIBLE will be allowed.
     */
    case BLOCK_LOW_AND_ABOVE = 'BLOCK_LOW_AND_ABOVE';

    /**
     * Content with NEGLIGIBLE and LOW will be allowed.
     */
    case BLOCK_MEDIUM_AND_ABOVE = 'BLOCK_MEDIUM_AND_ABOVE';

    /**
     * Content with NEGLIGIBLE, LOW, and MEDIUM will be allowed.
     */
    case BLOCK_ONLY_HIGH = 'BLOCK_ONLY_HIGH';

    /**
     * All content will be allowed.
     */
    case BLOCK_NONE = 'BLOCK_NONE';

    /**
     * Turn off the safety filter.
     */
    case OFF = 'OFF';
}
