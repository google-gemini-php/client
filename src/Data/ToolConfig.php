<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * The Tool configuration containing parameters for specifying Tool use in the request.
 *
 * https://ai.google.dev/api/caching#ToolConfig
 */
final class ToolConfig implements Arrayable
{
    public function __construct(
        public ?FunctionCallingConfig $functionCallingConfig = null,
    ) {}

    public function toArray(): array
    {
        return [
            'functionCallingConfig' => $this->functionCallingConfig?->toArray(),
        ];
    }
}
