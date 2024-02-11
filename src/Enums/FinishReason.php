<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Defines the reason why the model stopped generating tokens.
 *
 * https://ai.google.dev/api/rest/v1/GenerateContentResponse#finishreason
 */
enum FinishReason: string
{
    /**
     * Default value. This value is unused.
     */
    case FINISH_REASON_UNSPECIFIED = 'FINISH_REASON_UNSPECIFIED';

    /**
     * Natural stop point of the model or provided stop sequence.
     */
    case STOP = 'STOP';

    /**
     * The maximum number of tokens as specified in the request was reached.
     */
    case MAX_TOKENS = 'MAX_TOKENS';

    /**
     * The candidate content was flagged for safety reasons.
     */
    case SAFETY = 'SAFETY';

    /**
     * The candidate content was flagged for recitation reasons.
     */
    case RECITATION = 'RECITATION';

    /**
     * Unknown reason.
     */
    case OTHER = 'OTHER';
}
