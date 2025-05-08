<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Specifies the reason why the prompt was blocked.
 *
 * https://ai.google.dev/api/generate-content#BlockReason
 */
enum BlockReason: string
{
    /**
     * Default value. This value is unused.
     */
    case BLOCK_REASON_UNSPECIFIED = 'BLOCK_REASON_UNSPECIFIED';

    /**
     * Prompt was blocked due to safety reasons. You can inspect safetyRatings to understand which safety category blocked it.
     */
    case SAFETY = 'SAFETY';

    /**
     * Prompt was blocked due to unknown reasons.
     */
    case OTHER = 'OTHER';

    /**
     * Prompt was blocked due to the terms which are included from the terminology blocklist.
     */
    case BLOCKLIST = 'BLOCKLIST';

    /**
     * Prompt was blocked due to prohibited content.
     */
    case PROHIBITED_CONTENT = 'PROHIBITED_CONTENT';

    /**
     * Candidates blocked due to unsafe image generation content.
     */
    case IMAGE_SAFETY = 'IMAGE_SAFETY';
}
