<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * A list of floats representing an embedding.
 *
 * https://ai.google.dev/api/rest/v1/ContentEmbedding
 */
final class ContentEmbedding implements Arrayable
{
    /**
     * @param  array<float>  $values
     */
    public function __construct(
        public readonly array $values,
    ) {}

    /**
     * @param  array{ values: array<float> }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            values: $attributes['values'],
        );
    }

    public function toArray(): array
    {
        return [
            'values' => $this->values,
        ];
    }
}
