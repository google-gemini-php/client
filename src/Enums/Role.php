<?php

declare(strict_types=1);

namespace Gemini\Enums;

enum Role: string
{
    case USER = 'user';
    case MODEL = 'model';
}
