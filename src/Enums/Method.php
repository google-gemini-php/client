<?php

declare(strict_types=1);

namespace Gemini\Enums;

enum Method: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PATCH = 'PATCH';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
}
