<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * A predicted FunctionCall returned from the model that contains a string representing the FunctionDeclaration.name with the arguments and their values.
 *
 * https://ai.google.dev/api/caching#FunctionCall
 */
final class FunctionCall implements Arrayable
{
    /**
     * @param  string  $name  The name of the function to call. Must be a-z, A-Z, 0-9, or contain underscores and dashes, with a maximum length of 63.
     * @param  array<string, mixed>  $args  Optional. The function parameters and values in JSON object format.
     * @param  string|null  $id  Optional. The unique id of the function call. If populated, the client to execute the functionCall and return the response with the matching id.
     */
    public function __construct(
        public string $name,
        public array $args,
        public ?string $id = null,
    ) {}

    /**
     * @param  array{ name: string, args: array<string, mixed>|null, id?: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            args: $attributes['args'] ?? [],
            id: $attributes['id'] ?? null,
        );
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
        ];

        if ($this->args !== []) {
            $data['args'] = $this->args;
        }

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
