<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * The probability that a piece of content is harmful.
 * The classification system gives the probability of the content being unsafe. This does not indicate the severity of harm for a piece of content.
 *
 * https://ai.google.dev/api/rest/v1/GenerateContentResponse#harmprobability
 */
enum HarmProbability: string
{
    /**
     * Probability is unspecified.
     */
    case HARM_PROBABILITY_UNSPECIFIED = 'HARM_PROBABILITY_UNSPECIFIED';

    /**
     * Content has a negligible chance of being unsafe.
     */
    case NEGLIGIBLE = 'NEGLIGIBLE';

    /**
     * Content has a low chance of being unsafe.
     */
    case LOW = 'LOW';

    /**
     * Content has a medium chance of being unsafe.
     */
    case MEDIUM = 'MEDIUM';

    /**
     * Content has a high chance of being unsafe.
     */
    case HIGH = 'HIGH';
}
