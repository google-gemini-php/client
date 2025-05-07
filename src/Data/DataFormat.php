<?php

declare(strict_types=1);

namespace Gemini\Data;

enum DataFormat: string
{
    // for Number
    case FLOAT = 'float';
    case DOUBLE = 'double';

    // for Integer
    case INT32 = 'int32';
    case INT64 = 'int64';

    // for String
    case ENUM = 'enum';
    case DATETIME = 'date-time';
}
