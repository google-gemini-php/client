<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\ResponseMimeType;

/**
 * Configuration options for model generation and outputs.
 *
 * https://ai.google.dev/api/rest/v1beta/GenerationConfig
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
     * @param  ResponseMimeType|null  $responseMimeType  MIME type of the generated candidate text.
     * @param  Schema|null  $responseSchema  Output schema of the generated candidate text.
     * @param  float|null  $presencePenalty  Presence penalty applied to the next token's logprobs if the token has already been seen in the response.
     * @param  float|null  $frequencyPenalty  Frequency penalty applied to the next token's logprobs, multiplied by the number of times each token has been seen in the respponse so far.
     * @param  bool|null  $responseLogprobs  If true, export the logprobs results in response.
     * @param  int|null  $logprobs  Only valid if responseLogprobs=True. This sets the number of top logprobs to return at each decoding step in the Candidate.logprobs_result.
     */
    public function __construct(
        public readonly int $candidateCount = 1,
        public readonly array $stopSequences = [],
        public readonly ?int $maxOutputTokens = null,
        public readonly ?float $temperature = null,
        public readonly ?float $topP = null,
        public readonly ?int $topK = null,
        public readonly ?ResponseMimeType $responseMimeType = ResponseMimeType::TEXT_PLAIN,
        public readonly ?Schema $responseSchema = null,
        public readonly ?float $presencePenalty = null,
        public readonly ?float $frequencyPenalty = null,
        public readonly ?bool $responseLogprobs = null,
        public readonly ?int $logprobs = null,
    ) {}

    public function toArray(): array
    {
        return array_filter(
            array: [
                'candidateCount' => $this->candidateCount,
                'stopSequences' => $this->stopSequences,
                'maxOutputTokens' => $this->maxOutputTokens,
                'temperature' => $this->temperature,
                'topP' => $this->topP,
                'topK' => $this->topK,
                'responseMimeType' => $this->responseMimeType?->value,
                'responseSchema' => $this->responseSchema?->toArray(),
                'presencePenalty' => $this->presencePenalty,
                'frequencyPenalty' => $this->frequencyPenalty,
                'responseLogprobs' => $this->responseLogprobs,
                'logprobs' => $this->logprobs,
            ]
        );
    }
}
