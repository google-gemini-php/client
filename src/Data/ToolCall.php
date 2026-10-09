<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\ToolType;

/**
 * A predicted server-side tool call returned from the model. The client is not expected to execute it, but to pass it back to the API in a subsequent turn along with the corresponding ToolResponse.
 *
 * https://ai.google.dev/api/caching#ToolCall
 */
final class ToolCall implements Arrayable
{
    /**
     * @param  ToolType|null  $toolType  Required. The type of tool that was called.
     * @param  string|null  $toolName  Optional. The name of the tool that was called.
     * @param  array<string, mixed>  $args  Optional. The tool call arguments.
     * @param  string|null  $id  Optional. Unique identifier of the tool call. The server returns the tool response with the matching id.
     */
    public function __construct(
        public readonly ?ToolType $toolType = null,
        public readonly ?string $toolName = null,
        public readonly array $args = [],
        public readonly ?string $id = null,
    ) {}

    /**
     * @param  array{ toolType?: string, toolName?: string, args?: array<string, mixed>, id?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            toolType: isset($attributes['toolType']) ? ToolType::tryFrom($attributes['toolType']) : null,
            toolName: $attributes['toolName'] ?? null,
            args: $attributes['args'] ?? [],
            id: $attributes['id'] ?? null,
        );
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->toolType !== null) {
            $data['toolType'] = $this->toolType->value;
        }

        if ($this->toolName !== null) {
            $data['toolName'] = $this->toolName;
        }

        if ($this->args !== []) {
            $data['args'] = $this->args;
        }

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
