<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * The IANA standard MIME type of the source data.
 *
 * https://ai.google.dev/api/rest/v1beta/Content#blob
 */
enum ResponseMimeType: string
{
    case TEXT_PLAIN = 'text/plain';
    case APPLICATION_JSON = 'application/json';
}
