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
     * @param  array<string, mixed>  $args  The function parameters and values to pass to the function.
     */
    public function __construct(
        public string $name,
        public array $args,
    ) {}

    /**
     * @param  array{ name: string, args: array<string, mixed>|null }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            args: $attributes['args'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'args' => $this->args,
        ];
    }
}
