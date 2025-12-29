<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Controls reasoning behavior.
 *
 * Gemini 3 Pro: low, high
 * Gemini 3 Flash: minimal, low, medium, high
 *
 * https://ai.google.dev/gemini-api/docs/thinking#thinking-levels
 */
enum ThinkingLevel: string
{
    case LOW = 'low';
    case HIGH = 'high';
    case MINIMAL = 'minimal';
    case MEDIUM = 'medium';
}
