<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * Status of the url retrieval.
 *
 * https://ai.google.dev/api/generate-content#UrlRetrievalStatus
 */
enum UrlRetrievalStatus: string
{
    /**
     * Default value. This value is unused.
     */
    case URL_RETRIEVAL_STATUS_UNSPECIFIED = 'URL_RETRIEVAL_STATUS_UNSPECIFIED';

    /**
     * Url retrieval is successful.
     */
    case URL_RETRIEVAL_STATUS_SUCCESS = 'URL_RETRIEVAL_STATUS_SUCCESS';

    /**
     * Url retrieval is failed due to error.
     */
    case URL_RETRIEVAL_STATUS_ERROR = 'URL_RETRIEVAL_STATUS_ERROR';

    /**
     * Url retrieval is failed because the content is behind paywall.
     */
    case URL_RETRIEVAL_STATUS_PAYWALL = 'URL_RETRIEVAL_STATUS_PAYWALL';

    /**
     * Url retrieval is failed because the content is unsafe.
     */
    case URL_RETRIEVAL_STATUS_UNSAFE = 'URL_RETRIEVAL_STATUS_UNSAFE';
}
