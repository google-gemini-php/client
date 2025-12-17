<?php

declare(strict_types=1);

namespace Gemini\Enums;

enum ThinkingLevel: string
{
    case LOW = 'low';
    case HIGH = 'high';
    case MINIMAL = 'minimal';
    case MEDIUM = 'medium';
}
