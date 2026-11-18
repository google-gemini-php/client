<?php

declare(strict_types=1);

namespace Gemini\Responses\Decisions;

use Gemini\Contracts\ResponseContract;
use Gemini\Data\Decisions\DecisionAnswer;
use Gemini\Data\UsageMetadata;
use Gemini\Testing\Responses\Concerns\Fakeable;

final class DecisionsResponse implements ResponseContract
{
    use Fakeable;

    /**
     * @param  array<string, DecisionAnswer>  $answers
     */
    public function __construct(
        public readonly array $answers,
        public readonly ?UsageMetadata $usageMetadata = null,
    ) {}

    /**
     * @param  array{answers?: array<string, array<string, mixed>>, usage?: array<string, mixed>, usageMetadata?: array<string, mixed>}  $attributes
     */
    public static function from(array $attributes): self
    {
        $answers = [];
        foreach ($attributes['answers'] ?? [] as $key => $answerData) {
            /** @var array{type: string, confidence: float|int, noul?: float|int|null, choice?: string|null, score?: float|int|null, probabilities?: array<string, float|int>|null, legend?: array<int|string, string>|null} $answerData */
            $answers[$key] = DecisionAnswer::from($answerData);
        }

        /** @var array{promptTokenCount?: int, totalTokenCount?: int, candidatesTokenCount: ?int, cachedContentTokenCount: ?int, toolUsePromptTokenCount: ?int, thoughtsTokenCount: ?int, promptTokensDetails: list<array{modality: string, tokenCount: int}>|null, cacheTokensDetails: list<array{modality: string, tokenCount: int}>|null, candidatesTokensDetails: list<array{modality: string, tokenCount: int}>|null, toolUsePromptTokensDetails: list<array{modality: string, tokenCount: int}>|null, serviceTier?: string}|null $rawUsage */
        $rawUsage = $attributes['usage'] ?? $attributes['usageMetadata'] ?? null;

        return new self(
            answers: $answers,
            usageMetadata: $rawUsage ? UsageMetadata::from($rawUsage) : null,
        );
    }

    public function answer(string $id): ?DecisionAnswer
    {
        return $this->answers[$id] ?? null;
    }

    /**
     * @return array{answers: array<string, array<string, mixed>>, usageMetadata: array<string, mixed>|null}
     */
    public function toArray(): array
    {
        /** @var array<string, mixed>|null $usageMetadata */
        $usageMetadata = $this->usageMetadata?->toArray();

        return [
            'answers' => array_map(
                static fn (DecisionAnswer $answer): array => $answer->toArray(),
                $this->answers
            ),
            'usageMetadata' => $usageMetadata,
        ];
    }
}
