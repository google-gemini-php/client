<?php

declare(strict_types=1);

namespace Gemini\Enums;

enum ModelType: string
{
    case GEMINI_PRO = 'models/gemini-pro';
    case GEMINI_PRO_1_0 = 'models/gemini-1.0-pro';
    case GEMINI_PRO_1_0_LATEST = 'models/gemini-1.0-pro-latest';
    case GEMINI_PRO_1_5 = 'models/gemini-1.5-pro';
    case GEMINI_PRO_1_5_FLASH = 'models/gemini-1.5-flash';
    case GEMINI_PRO_VISION = 'models/gemini-pro-vision';
    case EMBEDDING = 'models/embedding-001';
}
