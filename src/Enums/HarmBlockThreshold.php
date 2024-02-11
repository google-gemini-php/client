<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Controls the probability threshold at which harm is blocked.
 *
 * https://ai.google.dev/api/rest/v1/SafetySetting#harmblockthreshold
 */
enum HarmBlockThreshold: int
{
    /**
     * Threshold is unspecified.
     */
    case HARM_BLOCK_THRESHOLD_UNSPECIFIED = 0;

    /**
     * Content with NEGLIGIBLE will be allowed.
     */
    case BLOCK_LOW_AND_ABOVE = 1;

    /**
     * Content with NEGLIGIBLE and LOW will be allowed.
     */
    case BLOCK_MEDIUM_AND_ABOVE = 2;

    /**
     * Content with NEGLIGIBLE, LOW, and MEDIUM will be allowed.
     */
    case BLOCK_ONLY_HIGH = 3;

    /**
     * All content will be allowed.
     */
    case BLOCK_NONE = 4;

}
