<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Service tier of the request.
 *
 * https://ai.google.dev/api/generate-content#ServiceTier
 */
enum ServiceTier: string
{
    /**
     * Default service tier, which is standard.
     */
    case UNSPECIFIED = 'unspecified';

    /**
     * Standard service tier.
     */
    case STANDARD = 'standard';

    /**
     * Flex service tier.
     */
    case FLEX = 'flex';

    /**
     * Priority service tier.
     */
    case PRIORITY = 'priority';
}
