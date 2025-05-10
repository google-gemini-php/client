<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Supported programming languages for the generated code.
 *
 * https://ai.google.dev/api/caching#Language
 */
enum Language: string
{
    /**
     * Unspecified language. This value should not be used.
     */
    case LANGUAGE_UNSPECIFIED = 'LANGUAGE_UNSPECIFIED';

    /**
     * Python >= 3.10, with numpy and simpy available.
     */
    case PYTHON = 'PYTHON';
}
