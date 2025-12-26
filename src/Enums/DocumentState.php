<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * @link https://ai.google.dev/api/file-search/documents#State
 */
enum DocumentState: string
{
    /** The default value. This value is used if the state is omitted. */
    case StateUnspecified = 'STATE_UNSPECIFIED';
    /** Some Chunks of the Document are being processed (embedding and vector storage). */
    case Pending = 'STATE_PENDING';
    /** All Chunks of the Document is processed and available for querying. */
    case Active = 'STATE_ACTIVE';
    /** Some Chunks of the Document failed processing. */
    case Failed = 'STATE_FAILED';
}
