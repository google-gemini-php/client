<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Candidate for the logprobs token and score.
 *
 * https://ai.google.dev/api/generate-content#Candidate
 */
final class LogprobsCandidate implements Arrayable
{
    /**
     * @param  string  $token  The candidate’s token string value.
     * @param  int  $tokenId  The candidate’s token id value.
     * @param  float  $logProbability  The candidate's log probability.
     */
    public function __construct(
        public readonly string $token,
        public readonly int $tokenId,
        public readonly float $logProbability,
    ) {}

    /**
     * @param  array{ token: string, tokenId: int, logProbability: float }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            token: $attributes['token'],
            tokenId: $attributes['tokenId'],
            logProbability: $attributes['logProbability'],
        );
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            '$this->tokenId' => $this->tokenId,
            'logProbability' => $this->logProbability,
        ];
    }
}
