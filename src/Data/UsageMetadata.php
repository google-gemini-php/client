<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Metadata about token usage in the API response.
 */
final class UsageMetadata implements Arrayable
{
    /**
     * @param int $promptTokenCount The number of tokens in the prompt.
     * @param int $candidatesTokenCount The number of tokens in the generated candidates.
     * @param int $totalTokenCount The total number of tokens used.
     */
    public function __construct(
        public readonly int $promptTokenCount,
        public readonly int $candidatesTokenCount,
        public readonly int $totalTokenCount,
    ) {
    }

    /**
     * @param array{
     *     promptTokenCount: int,
     *     candidatesTokenCount: int,
     *     totalTokenCount: int
     * } $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            promptTokenCount: $attributes['promptTokenCount'],
            candidatesTokenCount: $attributes['candidatesTokenCount'],
            totalTokenCount: $attributes['totalTokenCount'],
        );
    }

    public function toArray(): array
    {
        return [
            'promptTokenCount' => $this->promptTokenCount,
            'candidatesTokenCount' => $this->candidatesTokenCount,
            'totalTokenCount' => $this->totalTokenCount,
        ];
    }
}
