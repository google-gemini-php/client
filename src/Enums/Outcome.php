<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Enumeration of possible outcomes of the code execution.
 *
 * https://ai.google.dev/api/caching#Outcome
 */
enum Outcome: string
{
    /**
     * Unspecified status. This value should not be used.
     */
    case OUTCOME_UNSPECIFIED = 'OUTCOME_UNSPECIFIED';

    /**
     * Code execution completed successfully.
     */
    case OUTCOME_OK = 'OUTCOME_OK';

    /**
     * Code execution finished but with a failure. stderr should contain the reason.
     */
    case OUTCOME_FAILED = 'OUTCOME_FAILED';

    /**
     * Code execution ran for too long, and was cancelled. There may or may not be a partial output present.
     */
    case OUTCOME_DEADLINE_EXCEEDED = 'OUTCOME_DEADLINE_EXCEEDED';
}
