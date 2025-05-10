<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Candidates with top log probabilities at each decoding step.
 *
 * https://ai.google.dev/api/generate-content#TopCandidates
 */
final class TopCandidates implements Arrayable
{
    /**
     * @param  array<LogprobsCandidate>  $candidates  Sorted by log probability in descending order.
     */
    public function __construct(
        public readonly array $candidates,
    ) {}

    /**
     * @param  array{ candidates: array<array{ token: string, tokenId: int, logProbability: float }> }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            candidates: array_map(
                static fn (array $candidate): LogprobsCandidate => LogprobsCandidate::from($candidate),
                $attributes['candidates'],
            ),
        );
    }

    public function toArray(): array
    {
        return [
            'candidates' => array_map(
                static fn (LogprobsCandidate $candidate): array => $candidate->toArray(),
                $this->candidates,
            ),
        ];
    }
}
