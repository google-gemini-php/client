<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Configuration options for model generation and outputs.
 *
 * https://ai.google.dev/api/rest/v1/GenerationConfig
 */
final class GenerationConfig implements Arrayable
{
    /**
     * @param  int  $candidateCount  Number of generated responses to return.
     * @param  array<string>  $stopSequences  The set of character sequences (up to 5) that will stop output generation. If specified, the API will stop at the first appearance of a stop sequence. The stop sequence will not be included as part of the response.
     * @param  int|null  $maxOutputTokens  The maximum number of tokens to include in a candidate.
     * @param  float|null  $temperature  Controls the randomness of the output.
     * @param  float|null  $topP  The maximum cumulative probability of tokens to consider when sampling.
     * @param  int|null  $topK  The maximum number of tokens to consider when sampling.
     */
    public function __construct(
        public readonly int $candidateCount = 1,
        public readonly array $stopSequences = [],
        public readonly ?int $maxOutputTokens = null,
        public readonly ?float $temperature = null,
        public readonly ?float $topP = null,
        public readonly ?int $topK = null,
    ) {}

    public function toArray(): array
    {
        return [
            'candidateCount' => $this->candidateCount,
            'stopSequences' => $this->stopSequences,
            'maxOutputTokens' => $this->maxOutputTokens,
            'temperature' => $this->temperature,
            'topP' => $this->topP,
            'topK' => $this->topK,
        ];
    }
}
