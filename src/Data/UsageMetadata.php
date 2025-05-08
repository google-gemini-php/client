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
     * @param  int  $totalTokenCount  Total token count for the generation request (prompt + response candidates).
     * @param  int|null  $candidatesTokenCount  Total number of tokens across all the generated response candidates.
     * @param  int|null  $cachedContentTokenCount  Number of tokens in the cached part of the prompt (the cached content)
     * @param  int|null  $toolUsePromptTokenCount  Number of tokens present in tool-use prompt(s).
     * @param  int|null  $thoughtsTokenCount  Number of tokens of thoughts for thinking models.
     * @param  list<ModalityTokenCount>|null  $promptTokensDetails  List of modalities that were processed in the request input.
     * @param  list<ModalityTokenCount>|null  $cacheTokensDetails  List of modalities of the cached content in the request input.
     * @param  list<ModalityTokenCount>|null  $candidatesTokensDetails  List of modalities that were returned in the response.
     * @param  list<ModalityTokenCount>|null  $toolUsePromptTokensDetails  List of modalities that were processed for tool-use request inputs.
     */
    public function __construct(
        public readonly int $promptTokenCount,
        public readonly int $totalTokenCount,
        public readonly ?int $candidatesTokenCount = null,
        public readonly ?int $cachedContentTokenCount = null,
        public readonly ?int $toolUsePromptTokenCount = null,
        public readonly ?int $thoughtsTokenCount = null,
        public readonly ?array $promptTokensDetails = null,
        public readonly ?array $cacheTokensDetails = null,
        public readonly ?array $candidatesTokensDetails = null,
        public readonly ?array $toolUsePromptTokensDetails = null,
    ) {}

    /**
     * @param  array{ promptTokenCount: int, totalTokenCount: int, candidatesTokenCount: ?int, cachedContentTokenCount: ?int, toolUsePromptTokenCount: ?int, thoughtsTokenCount: ?int, promptTokensDetails: list<array{ modality: string, tokenCount: int}>|null, cacheTokensDetails: list<array{ modality: string, tokenCount: int}>|null, candidatesTokensDetails: list<array{ modality: string, tokenCount: int}>|null, toolUsePromptTokensDetails: list<array{ modality: string, tokenCount: int}>|null }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            promptTokenCount: $attributes['promptTokenCount'],
            totalTokenCount: $attributes['totalTokenCount'],
            candidatesTokenCount: $attributes['candidatesTokenCount'] ?? null,
            cachedContentTokenCount: $attributes['cachedContentTokenCount'] ?? null,
            toolUsePromptTokenCount: $attributes['toolUsePromptTokenCount'] ?? null,
            thoughtsTokenCount: $attributes['thoughtsTokenCount'] ?? null,
            promptTokensDetails: array_map(
                static fn (array $promptTokensDetail): ModalityTokenCount => ModalityTokenCount::from($promptTokensDetail),
                $attributes['promptTokensDetails'] ?? [],
            ),
            cacheTokensDetails: array_map(
                static fn (array $cacheTokensDetail): ModalityTokenCount => ModalityTokenCount::from($cacheTokensDetail),
                $attributes['cacheTokensDetails'] ?? [],
            ),
            candidatesTokensDetails: array_map(
                static fn (array $candidatesTokensDetail): ModalityTokenCount => ModalityTokenCount::from($candidatesTokensDetail),
                $attributes['candidatesTokensDetails'] ?? [],
            ),
            toolUsePromptTokensDetails: array_map(
                static fn (array $toolUsePromptTokensDetail): ModalityTokenCount => ModalityTokenCount::from($toolUsePromptTokensDetail),
                $attributes['toolUsePromptTokensDetails'] ?? [],
            ),
        );
    }

    public function toArray(): array
    {
        return [
            'promptTokenCount' => $this->promptTokenCount,
            'candidatesTokenCount' => $this->candidatesTokenCount,
            'totalTokenCount' => $this->totalTokenCount,
            'cachedContentTokenCount' => $this->cachedContentTokenCount,
            'toolUsePromptTokenCount' => $this->toolUsePromptTokenCount,
            'thoughtsTokenCount' => $this->thoughtsTokenCount,
            'promptTokensDetails' => array_map(
                static fn (ModalityTokenCount $promptTokensDetail): array => $promptTokensDetail->toArray(),
                $this->promptTokensDetails ?? [],
            ),
            'cacheTokensDetails' => array_map(
                static fn (ModalityTokenCount $cacheTokensDetail): array => $cacheTokensDetail->toArray(),
                $this->cacheTokensDetails ?? [],
            ),
            'candidatesTokensDetails' => array_map(
                static fn (ModalityTokenCount $candidatesTokensDetail): array => $candidatesTokensDetail->toArray(),
                $this->candidatesTokensDetails ?? [],
            ),
            'toolUsePromptTokensDetails' => array_map(
                static fn (ModalityTokenCount $toolUsePromptTokensDetail): array => $toolUsePromptTokensDetail->toArray(),
                $this->toolUsePromptTokensDetails ?? [],
            ),
        ];
    }
}
