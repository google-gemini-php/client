<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Logprobs Result.
 *
 * https://ai.google.dev/api/generate-content#LogprobsResult
 */
final class LogprobsResult implements Arrayable
{
    /**
     * @param  array<TopCandidates>  $topCandidates  Length = total number of decoding steps.
     * @param  array<LogprobsCandidate>  $chosenCandidates  Length = total number of decoding steps. The chosen candidates may or may not be in topCandidates.
     */
    public function __construct(
        public readonly array $topCandidates,
        public readonly array $chosenCandidates,
    ) {}

    /**
     * @param  array{ topCandidates: array<array{ candidates: array<array{ token: string, tokenId: int, logProbability: float }> }>, chosenCandidates: array<array{ token: string, tokenId: int, logProbability: float }> }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            topCandidates: array_map(
                static fn (array $topCandidates): TopCandidates => TopCandidates::from($topCandidates),
                $attributes['topCandidates'],
            ),
            chosenCandidates: array_map(
                static fn (array $candidate): LogprobsCandidate => LogprobsCandidate::from($candidate),
                $attributes['chosenCandidates'],
            ),
        );
    }

    public function toArray(): array
    {
        return [
            'topCandidates' => array_map(
                static fn (TopCandidates $topCandidates): array => $topCandidates->toArray(),
                $this->topCandidates,
            ),
            'chosenCandidates' => array_map(
                static fn (LogprobsCandidate $candidate): array => $candidate->toArray(),
                $this->chosenCandidates,
            ),
        ];
    }
}
