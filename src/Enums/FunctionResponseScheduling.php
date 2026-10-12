<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Specifies how the function response should be scheduled in the conversation.
 *
 * https://ai.google.dev/api/caching#Scheduling
 */
enum FunctionResponseScheduling: string
{
    /**
     * This value is unused.
     */
    case SCHEDULING_UNSPECIFIED = 'SCHEDULING_UNSPECIFIED';

    /**
     * Only add the result to the conversation context, do not interrupt or trigger generation.
     */
    case SILENT = 'SILENT';

    /**
     * Add the result to the conversation context, and prompt to generate output without interrupting ongoing generation.
     */
    case WHEN_IDLE = 'WHEN_IDLE';

    /**
     * Add the result to the conversation context, interrupt ongoing generation and prompt to generate output.
     */
    case INTERRUPT = 'INTERRUPT';
}
