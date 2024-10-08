<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Metadata on the generation request's token usage.
 *
 * https://ai.google.dev/api/generate-content#UsageMetadata
 */
final class UsageMetadata implements Arrayable
{
    /**
     * @param  int  $promptTokenCount  Number of tokens in the prompt. When cachedContent is set, this is still the total effective prompt size meaning this includes the number of tokens in the cached content.
     * @param  int  $candidatesTokenCount  Total number of tokens across all the generated response candidates.
     * @param  int  $totalTokenCount  Total token count for the generation request (prompt + response candidates).
     * @param  int|null  $cachedContentTokenCount  Number of tokens in the cached part of the prompt (the cached content)
     */
    public function __construct(
        public readonly int $promptTokenCount,
        public readonly int $totalTokenCount,
        public readonly ?int $candidatesTokenCount = null,
        public readonly ?int $cachedContentTokenCount = null,
    ) {}

    /**
     * @param  array{ promptTokenCount: int, candidatesTokenCount: ?int, totalTokenCount: int, cachedContentTokenCount: ?int }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            promptTokenCount: $attributes['promptTokenCount'],
            totalTokenCount: $attributes['totalTokenCount'],
            candidatesTokenCount: $attributes['candidatesTokenCount'] ?? null,
            cachedContentTokenCount: $attributes['cachedContentTokenCount'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'promptTokenCount' => $this->promptTokenCount,
            'candidatesTokenCount' => $this->candidatesTokenCount,
            'totalTokenCount' => $this->totalTokenCount,
            'cachedContentTokenCount' => $this->cachedContentTokenCount,
        ];
    }
}
