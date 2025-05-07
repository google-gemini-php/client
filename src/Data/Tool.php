<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Tool details that the model may use to generate response.
 *
 * https://ai.google.dev/api/caching#Tool
 */
final class Tool implements Arrayable
{
    /**
     * @param  array<array-key, FunctionDeclaration>  $functionDeclarations  A list of FunctionDeclarations available to the model that can be used for function calling.
     */
    public function __construct(
        public ?array $functionDeclarations = null,
    ) {}

    public function toArray(): array
    {
        return [
            'functionDeclarations' => array_map(static fn (FunctionDeclaration $functionDeclaration) => $functionDeclaration->toArray(), $this->functionDeclarations ?? []),
        ];
    }
}
