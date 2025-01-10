<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\Mode;

/**
 * Configuration for specifying function calling behavior.
 *
 * https://ai.google.dev/api/caching#FunctionCallingConfig
 */
final class FunctionCallingConfig implements Arrayable
{
    /**
     * @param  Mode  $mode  Specifies the mode in which function calling should execute.
     * @param  array<array-key, string>|null  $allowedFunctionNames  A set of function names that, when provided, limits the functions the model will call.
     */
    public function __construct(
        public Mode $mode,
        public ?array $allowedFunctionNames = null,
    ) {}

    public function toArray(): array
    {
        return [
            'mode' => $this->mode->value,
            'allowedFunctionNames' => $this->allowedFunctionNames,
        ];
    }
}
