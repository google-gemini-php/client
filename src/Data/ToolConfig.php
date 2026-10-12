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
        public ?RetrievalConfig $retrievalConfig = null,
        public ?bool $includeServerSideToolInvocations = null,
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->functionCallingConfig !== null) {
            $data['functionCallingConfig'] = $this->functionCallingConfig->toArray();
        }

        if ($this->retrievalConfig !== null) {
            $data['retrievalConfig'] = $this->retrievalConfig->toArray();
        }

        if ($this->includeServerSideToolInvocations !== null) {
            $data['includeServerSideToolInvocations'] = $this->includeServerSideToolInvocations;
        }

        return $data;
    }
}
