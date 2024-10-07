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
    // Images
    case IMAGE_PNG = 'image/png';
    case IMAGE_JPEG = 'image/jpeg';
    case IMAGE_HEIC = 'image/heic';
    case IMAGE_HEIF = 'image/heif';
    case IMAGE_WEBP = 'image/webp';

    // Audio
    case AUDIO_WAV = 'audio/wav';
    case AUDIO_MP3 = 'audio/mp3';
    case AUDIO_AIFF = 'audio/aiff';
    case AUDIO_AAC = 'audio/aac';
    case AUDIO_OGG = 'audio/ogg';
    case AUDIO_FLAC = 'audio/flac';

    // Video
    case VIDEO_MP4 = 'video/mp4';
    case VIDEO_MPEG = 'video/mpeg';
    case VIDEO_MOV = 'video/mov';
    case VIDEO_AVI = 'video/avi';
    case VIDEO_FLV = 'video/x-flv';
    case VIDEO_MPG = 'video/mpg';
    case VIDEO_WEBM = 'video/webm';
    case VIDEO_WMV = 'video/wmv';
    case VIDEO_3GPP = 'video/3gpp';

    // Plain text
    case TEXT_PLAIN = 'text/plain';
    case TEXT_HTML = 'text/html';
    case TEXT_CSS = 'text/css';
    case TEXT_JAVASCRIPT = 'text/javascript';
    case APPLICATION_X_JAVASCRIPT = 'application/x-javascript';
    case TEXT_X_TYPESCRIPT = 'text/x-typescript';
    case APPLICATION_X_TYPESCRIPT = 'application/x-typescript';
    case TEXT_CSV = 'text/csv';
    case TEXT_MARKDOWN = 'text/markdown';
    case TEXT_X_PYTHON = 'text/x-python';
    case APPLICATION_X_PYTHON_CODE = 'application/x-python-code';
    case APPLICATION_JSON = 'application/json';
    case TEXT_XML = 'text/xml';
    case APPLICATION_RTF = 'application/rtf';
    case TEXT_RTF = 'text/rtf';

    // Pdf
    case APPLICATION_PDF = 'application/pdf';
}
