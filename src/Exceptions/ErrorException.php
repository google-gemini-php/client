<?php

declare(strict_types=1);

namespace Gemini\Exceptions;

use Exception;

final class ErrorException extends Exception
{
    /**
     * Creates a new Exception instance.
     *
     * @param  array{code: int, message: string, status: string }  $contents
     */
    public function __construct(private readonly array $contents)
    {
        $message = ($contents['message'] ?: (string) $this->contents['code']) ?: 'Unknown error';

        parent::__construct($message);
    }

    /**
     * Returns the error message.
     */
    public function getErrorMessage(): string
    {
        return $this->getMessage();
    }

    /**
     * Returns the error status.
     */
    public function getErrorStatus(): ?string
    {
        return $this->contents['status'];
    }

    /**
     * Returns the error code.
     */
    public function getErrorCode(): string|int|null
    {
        return $this->contents['code'];
    }
}
