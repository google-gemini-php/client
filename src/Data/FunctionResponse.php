<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * The result output from a FunctionCall that contains a string representing the FunctionDeclaration.name and a structured JSON object containing any output from the function is used as context to the model. This should contain the result of aFunctionCall made based on model prediction.
 *
 * https://ai.google.dev/api/caching#FunctionResponse
 */
final class FunctionResponse implements Arrayable
{
    /**
     * @param  string  $name  The name of the function to call. Must be a-z, A-Z, 0-9, or contain underscores and dashes, with a maximum length of 63.
     * @param  array<string, mixed>  $response  The function response in JSON object format.
     * @param  string|null  $id  Optional. The id of the function call this response is for. Populated by the client to match the corresponding function call id.
     */
    public function __construct(
        public string $name,
        public array $response,
        public ?string $id = null,
    ) {}

    /**
     * @param  array{ name: string, response: array<string, mixed>, id?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            response: $attributes['response'],
            id: $attributes['id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'response' => $this->response,
            'id' => $this->id,
        ];
    }
}
