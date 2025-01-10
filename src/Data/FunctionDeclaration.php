<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Structured representation of a function declaration.
 *
 * https://ai.google.dev/api/caching#FunctionDeclaration
 */
final class FunctionDeclaration implements Arrayable
{
    /**
     * @param  string  $name  The name of the function. Must be a-z, A-Z, 0-9, or contain underscores and dashes, with a maximum length of 63.
     * @param  string  $description  A brief description of the function.
     * @param  Schema|null  $parameters  Describes the parameters to this function. Supports only `type`, `properties`, and `required` fields.
     */
    public function __construct(
        public string $name,
        public string $description,
        public ?Schema $parameters = null,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'parameters' => $this->parameters?->toArray(),
        ];
    }
}
