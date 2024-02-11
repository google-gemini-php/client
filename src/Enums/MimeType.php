<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * The IANA standard MIME type of the source data.
 *
 * https://ai.google.dev/api/rest/v1/Content#blob
 */
enum MimeType: string
{
    case IMAGE_PNG = 'image/png';
    case IMAGE_JPEG = 'image/jpeg';
    case IMAGE_HEIC = 'image/heic';
    case IMAGE_HEIF = 'image/heif';
    case IMAGE_WEBP = 'image/webp';
}
