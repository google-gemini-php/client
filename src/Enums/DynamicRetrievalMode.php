<?php

namespace Gemini\Enums;

/**
 * The mode of the predictor to be used in dynamic retrieval.
 *
 * https://ai.google.dev/api/caching#Mode
 */
enum DynamicRetrievalMode: string
{
    /**
     * Always trigger retrieval.
     */
    case MODE_UNSPECIFIED = 'MODE_UNSPECIFIED';

    /**
     * Run retrieval only when system decides it is necessary.
     */
    case MODE_DYNAMIC = 'MODE_DYNAMIC';
}
