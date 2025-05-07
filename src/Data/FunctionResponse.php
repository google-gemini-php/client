<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * The result output from a FunctionCall.
 *
 * https://ai.google.dev/api/caching#FunctionResponse
 */
final class FunctionResponse implements Arrayable
{
    /**
     * @param  string  $name  The name of the function to call. Must be a-z, A-Z, 0-9, or contain underscores and dashes, with a maximum length of 63.
     * @param  array<string, mixed>  $response  The function response in JSON object format.
     */
    public function __construct(
        public string $name,
        public array $response,
    ) {}

    /**
     * @param  array{ name: string, response: array<string, mixed> }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            response: $attributes['response'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'response' => $this->response,
        ];
    }
}
