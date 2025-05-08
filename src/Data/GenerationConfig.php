<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\MediaResolution;
use Gemini\Enums\ResponseMimeType;
use Gemini\Enums\ResponseModality;

/**
 * Configuration options for model generation and outputs. Not all parameters are configurable for every model.
 *
 * https://ai.google.dev/api/generate-content#generationconfig
 */
final class GenerationConfig implements Arrayable
{
    /**
     * @param  int  $candidateCount  Optional. Number of generated responses to return. If unset, this will default to 1. Please note that this doesn't work for previous generation models (Gemini 1.0 family)
     * @param  array<string>  $stopSequences  Optional. The set of character sequences (up to 5) that will stop output generation. If specified, the API will stop at the first appearance of a stop_sequence. The stop sequence will not be included as part of the response.
     * @param  int|null  $maxOutputTokens  Optional. The maximum number of tokens to include in a response candidate. Note: The default value varies by model, see the Model.output_token_limit attribute of the Model returned from the getModel function.
     * @param  float|null  $temperature  Optional. Controls the randomness of the output. Note: The default value varies by model, see the Model.temperature attribute of the Model returned from the getModel function. Values can range from [0.0, 2.0].
     * @param  float|null  $topP  Optional. The maximum cumulative probability of tokens to consider when sampling. The model uses combined Top-k and Top-p (nucleus) sampling. Tokens are sorted based on their assigned probabilities so that only the most likely tokens are considered. Top-k sampling directly limits the maximum number of tokens to consider, while Nucleus sampling limits the number of tokens based on the cumulative probability. Note: The default value varies by Model and is specified by theModel.top_p attribute returned from the getModel function. An empty topK attribute indicates that the model doesn't apply top-k sampling and doesn't allow setting topK on requests.
     * @param  int|null  $topK  Optional. The maximum number of tokens to consider when sampling. Gemini models use Top-p (nucleus) sampling or a combination of Top-k and nucleus sampling. Top-k sampling considers the set of topK most probable tokens. Models running with nucleus sampling don't allow topK setting. Note: The default value varies by Model and is specified by theModel.top_p attribute returned from the getModel function. An empty topK attribute indicates that the model doesn't apply top-k sampling and doesn't allow setting topK on requests.
     * @param  ResponseMimeType|null  $responseMimeType  Optional. MIME type of the generated candidate text. Supported MIME types are: text/plain: (default) Text output. application/json: JSON response in the response candidates. text/x.enum: ENUM as a string response in the response candidates.
     * @param  Schema|null  $responseSchema  Optional. Output schema of the generated candidate text. Schemas must be a subset of the OpenAPI schema and can be objects, primitives or arrays. If set, a compatible responseMimeType must also be set. Compatible MIME types: application/json: Schema for JSON response.
     * @param  float|null  $presencePenalty  Optional. Presence penalty applied to the next token's logprobs if the token has already been seen in the response. This penalty is binary on/off and not dependant on the number of times the token is used (after the first). Use frequencyPenalty for a penalty that increases with each use. A positive penalty will discourage the use of tokens that have already been used in the response, increasing the vocabulary. A negative penalty will encourage the use of tokens that have already been used in the response, decreasing the vocabulary.
     * @param  float|null  $frequencyPenalty  Optional. Frequency penalty applied to the next token's logprobs, multiplied by the number of times each token has been seen in the respponse so far. A positive penalty will discourage the use of tokens that have already been used, proportional to the number of times the token has been used: The more a token is used, the more difficult it is for the model to use that token again increasing the vocabulary of responses. Caution: A negative penalty will encourage the model to reuse tokens proportional to the number of times the token has been used. Small negative values will reduce the vocabulary of a response. Larger negative values will cause the model to start repeating a common token until it hits the maxOutputTokens limit.
     * @param  bool|null  $responseLogprobs  Optional. If true, export the logprobs results in response.
     * @param  int|null  $logprobs  Optional. Only valid if responseLogprobs=True. This sets the number of top logprobs to return at each decoding step in the Candidate.logprobs_result.
     * @param  array<ResponseModality>|null  $responseModalities  Optional. The requested modalities of the response. Represents the set of modalities that the model can return, and should be expected in the response. This is an exact match to the modalities of the response. A model may have multiple combinations of supported modalities. If the requested modalities do not match any of the supported combinations, an error will be returned. An empty list is equivalent to requesting only text.
     * @param  int|null  $seed  Optional. Seed used in decoding. If not set, the request uses a randomly generated seed.
     * @param  bool|null  $enableEnhancedCivicAnswers  Optional. Enables enhanced civic answers. It may not be available for all models.
     * @param  SpeechConfig|null  $speechConfig  Optional. The speech generation config.
     * @param  ThinkingConfig|null  $thinkingConfig  Optional. Config for thinking features. An error will be returned if this field is set for models that don't support thinking.
     * @param  MediaResolution|null  $mediaResolution  Optional. If specified, the media resolution specified will be used.
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
        public readonly ?array $responseModalities = null,
        public readonly ?int $seed = null,
        public readonly ?bool $enableEnhancedCivicAnswers = null,
        public readonly ?SpeechConfig $speechConfig = null,
        public readonly ?ThinkingConfig $thinkingConfig = null,
        public readonly ?MediaResolution $mediaResolution = null,
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
                'responseModalities' => array_map(
                    static fn (ResponseModality $modality): string => $modality->value,
                    $this->responseModalities ?? []
                ),
                'seed' => $this->seed,
                'enableEnhancedCivicAnswers' => $this->enableEnhancedCivicAnswers,
                'speechConfig' => $this->speechConfig?->toArray(),
                'thinkingConfig' => $this->thinkingConfig?->toArray(),
                'mediaResolution' => $this->mediaResolution?->value,
            ]
        );
    }
}
