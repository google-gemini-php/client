<?php

declare(strict_types=1);

namespace Gemini\Enums;

/**
 * @link https://ai.google.dev/api/files#State
 */
enum FileState: string
{
    /** The default value. This value is used if the state is omitted. */
    case StateUnspecified = 'STATE_UNSPECIFIED';
    /** File is being processed and cannot be used for inference yet. */
    case Processing = 'PROCESSING';
    /** File is processed and available for inference. */
    case Active = 'ACTIVE';
    /** File failed processing. */
    case Failed = 'FAILED';

    public function complete(): bool
    {
        return match ($this) {
            self::StateUnspecified, self::Processing => false,
            self::Active, self::Failed => true,
        };
    }
}
