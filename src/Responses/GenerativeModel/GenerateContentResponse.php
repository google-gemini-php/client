<?php

declare(strict_types=1);

namespace Gemini\Responses\GenerativeModel;

use Gemini\Contracts\ResponseContract;
use Gemini\Data\Candidate;
use Gemini\Data\Part;
use Gemini\Data\PromptFeedback;
use Gemini\Data\UsageMetadata;
use Gemini\Testing\Responses\Concerns\Fakeable;
use Gemini\Testing\Responses\Concerns\FakeableForStreamedResponse;
use ValueError;

/**
 * ResponseDTO from the model supporting multiple candidates.
 *
 * https://ai.google.dev/api/generate-content#generatecontentresponse
 */
final class GenerateContentResponse implements ResponseContract
{
    use Fakeable;
    use FakeableForStreamedResponse;

    /**
     * @param  array<Candidate>  $candidates  Candidate responses from the model.
     * @param  UsageMetadata  $usageMetadata  Output only. Metadata on the generation requests' token usage.
     * @param  PromptFeedback|null  $promptFeedback  Returns the prompt's feedback related to the content filters.
     * @param  string|null  $modelVersion  The model version used to generate the response.
     */
    public function __construct(
        public readonly array $candidates,
        public readonly UsageMetadata $usageMetadata,
        public readonly ?PromptFeedback $promptFeedback = null,
        public readonly ?string $modelVersion = null,
    ) {}

    /**
     * A quick accessor equivalent to `$candidates[0]->content->parts`
     *
     * @return array<Part>
     */
    public function parts(): array
    {
        if (empty($this->candidates)) {
            throw new ValueError(
                message: 'The `GenerateContentResponse::parts()` quick accessor only works for a single candidate,'.
                'but none were returned. Check the `GenerateContentResponse::$promptFeedback` to see if the prompt was blocked.'
            );
        }

        if (count($this->candidates) > 1) {
            throw new ValueError(
                message: 'The `response.parts` quick accessor only works with a '.
                'single candidate. With multiple candidates use '.
                'GenerateContentResponse::$candidates[index].content.parts[0].text'
            );
        }

        return $this->candidates[0]->content->parts;
    }

    /**
     * A quick accessor equivalent to `$candidates[0].parts[0].text`
     */
    public function text(): string
    {
        $parts = $this->parts();

        if (empty($parts)) {
            throw new ValueError(
                message: 'The `GenerateContentResponse::text()` quick accessor only works when the response contains a valid '.
                '`Part`, but none was returned. Check the `candidate.safety_ratings` to see if the '.
                'response was blocked.'
            );
        }

        if (count($parts) !== 1 || $parts[0]->text === null) {
            throw new ValueError(
                'The `GenerateContentResponse::text()` quick accessor only works for '.
               'simple (single-`Part`) text responses. This response is not simple text. '.
                'Use the `GenerateContentResponse::parts()` accessor or the full '.
                '`GenerateContentResponse::$candidates[index].content.parts` lookup '.
                'instead.'
            );
        }

        return $parts[0]->text;
    }

    /**
     * A quick accessor equivalent to `json_decode($candidates[0].parts[0].text)`
     */
    public function json(bool $associative = false, int $flags = 0): mixed
    {
        return json_decode($this->text(), associative: $associative, flags: $flags);
    }

    /**
     * @param  array{ candidates: ?array<array{ content: ?array{ parts: array{ array{ text: ?string, inlineData: ?array{ mimeType: string, data: string }, fileData: ?array{ fileUri: string, mimeType: string }, functionCall: ?array{ name: string, args: array<string, mixed>|null }, functionResponse: ?array{ name: string, response: array<string, mixed> } } }, role: string }, finishReason: ?string, safetyRatings: ?array{ array{ category: string, probability: string, blocked: ?bool } }, citationMetadata: ?array{ citationSources: array{ array{ startIndex: int, endIndex: int, uri: ?string, license: ?string} } }, index: ?int, tokenCount: ?int, avgLogprobs: ?float, groundingAttributions: ?array<array{ sourceId: array{ groundingPassage?: array{ passageId: string, partIndex: int }, semanticRetrieverChunk?: array{ source: string, chunk: string } }, content: array{ parts: array{ array{ text: ?string, inlineData: ?array{ mimeType: string, data: string }, fileData: ?array{ fileUri: string, mimeType: string }, functionCall: ?array{ name: string, args: array<string, mixed>|null }, functionResponse: ?array{ name: string, response: array<string, mixed> } } }, role: string } }>, groundingMetadata?: array{ groundingChunks: ?array<array{ web: null|array{ title: ?string, uri: ?string } }>, groundingSupports: ?array<array{ groundingChunkIndices: array<int>|null, confidenceScores: array<float>|null, segment: ?array{ partIndex: ?int, startIndex: ?int, endIndex: ?int, text: ?string } }>, webSearchQueries: ?array<string>, searchEntryPoint?: array{ renderedContent?: string|null, sdkBlob?: string|null }, retrievalMetadata: ?array{ googleSearchDynamicRetrievalScore?: float|null } }, logprobsResult?: array{ topCandidates: array<array{ candidates: array<array{ token: string, tokenId: int, logProbability: float }> }>, chosenCandidates: array<array{ token: string, tokenId: int, logProbability: float }> }, urlRetrievalMetadata?: array{ urlRetrievalContexts: array<array{ retrievedUrl: string }> } }>, promptFeedback: ?array{ safetyRatings: array{ array{ category: string, probability: string, blocked: ?bool } }, blockReason: ?string }, usageMetadata: array{ promptTokenCount: int, totalTokenCount: int, candidatesTokenCount: ?int, cachedContentTokenCount: ?int, toolUsePromptTokenCount: ?int, thoughtsTokenCount: ?int, promptTokensDetails: list<array{ modality: string, tokenCount: int}>|null, cacheTokensDetails: list<array{ modality: string, tokenCount: int}>|null, candidatesTokensDetails: list<array{ modality: string, tokenCount: int}>|null, toolUsePromptTokensDetails: list<array{ modality: string, tokenCount: int}>|null }, modelVersion: ?string }  $attributes
     */
    public static function from(array $attributes): self
    {
        $candidates = array_map(
            static fn (array $candidate): Candidate => Candidate::from($candidate),
            $attributes['candidates'] ?? [],
        );

        $promptFeedback = match (true) {
            isset($attributes['promptFeedback']) => PromptFeedback::from($attributes['promptFeedback']),
            default => null
        };

        return new self(
            candidates: $candidates,
            usageMetadata: UsageMetadata::from($attributes['usageMetadata']),
            promptFeedback: $promptFeedback,
            modelVersion: $attributes['modelVersion'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'candidates' => array_map(
                static fn (Candidate $candidate): array => $candidate->toArray(),
                $this->candidates
            ),
            'promptFeedback' => $this->promptFeedback?->toArray(),
            'usageMetadata' => $this->usageMetadata->toArray(),
            'modelVersion' => $this->modelVersion,
        ];
    }
}
