<?php

declare(strict_types=1);

namespace Gemini\Enums;

enum ModelType: string
{
    case GEMINI_PRO = 'models/gemini-pro';
    case GEMINI_PRO_VISION = 'models/gemini-pro-vision';
    case GEMINI_FLASH = 'models/gemini-1.5-flash';
    case EMBEDDING = 'models/embedding-001';
    case TEXT_EMBEDDING = 'models/text-embedding-004';
}
