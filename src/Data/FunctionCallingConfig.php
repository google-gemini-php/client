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
     * @param  array<array-key, string>|null  $allowedFunctionNames  Optional. A set of function names that, when provided, limits the functions the model will call. This should only be set when the Mode is ANY. Function names should match [FunctionDeclaration.name]. With mode set to ANY, model will predict a function call from the set of function names provided.
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
