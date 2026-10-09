<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\ToolType;

/**
 * The output from a server-side ToolCall execution. The client should pass it back to the API in a subsequent turn along with the corresponding ToolCall.
 *
 * https://ai.google.dev/api/caching#ToolResponse
 */
final class ToolResponse implements Arrayable
{
    /**
     * @param  ToolType|null  $toolType  Required. The type of tool that was called, matching the toolType in the corresponding ToolCall.
     * @param  array<string, mixed>  $response  Optional. The tool response.
     * @param  string|null  $id  Optional. The identifier of the tool call this response is for.
     */
    public function __construct(
        public readonly ?ToolType $toolType = null,
        public readonly array $response = [],
        public readonly ?string $id = null,
    ) {}

    /**
     * @param  array{ toolType?: string, response?: array<string, mixed>, id?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            toolType: isset($attributes['toolType']) ? ToolType::tryFrom($attributes['toolType']) : null,
            response: $attributes['response'] ?? [],
            id: $attributes['id'] ?? null,
        );
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->toolType !== null) {
            $data['toolType'] = $this->toolType->value;
        }

        if ($this->response !== []) {
            $data['response'] = $this->response;
        }

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
