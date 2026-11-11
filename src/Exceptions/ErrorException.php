<?php

declare(strict_types=1);

namespace Gemini\Exceptions;

use Exception;

final class ErrorException extends Exception
{
    /**
     * Creates a new Exception instance.
     *
     * @param  array{code: int, message: string, status: string, details?: array<int, array<string, mixed>> }  $contents
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
    public function getErrorStatus(): string
    {
        return $this->contents['status'];
    }

    /**
     * Returns the error code.
     */
    public function getErrorCode(): int
    {
        return $this->contents['code'];
    }

    /**
     * Returns the details of the error, such as the google.rpc.QuotaFailure and google.rpc.RetryInfo of a 429.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getErrorDetails(): array
    {
        return $this->contents['details'] ?? [];
    }

    /**
     * Returns the seconds to wait before retrying, from the google.rpc.RetryInfo detail of the error, rounded up.
     */
    public function getRetryDelay(): ?int
    {
        foreach ($this->getErrorDetails() as $detail) {
            if (($detail['@type'] ?? null) !== 'type.googleapis.com/google.rpc.RetryInfo') {
                continue;
            }

            $retryDelay = $detail['retryDelay'] ?? null;

            if (is_string($retryDelay) && preg_match('/^(\d+(?:\.\d+)?)s$/', $retryDelay, $matches) === 1) {
                return (int) ceil((float) $matches[1]);
            }
        }

        return null;
    }
}
