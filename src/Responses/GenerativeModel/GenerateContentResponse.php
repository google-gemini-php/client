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
 * https://ai.google.dev/api/rest/v1/GenerateContentResponse
 */
final class GenerateContentResponse implements ResponseContract
{
    use Fakeable;
    use FakeableForStreamedResponse;

    /**
     * @param  array<Candidate>  $candidates  Candidate responses from the model.
     * @param  UsageMetadata  $usageMetadata  Output only. Metadata on the generation requests' token usage.
     * @param  PromptFeedback|null  $promptFeedback  Returns the prompt's feedback related to the content filters.
     */
    public function __construct(
        public readonly array $candidates,
        public readonly UsageMetadata $usageMetadata,
        public readonly ?PromptFeedback $promptFeedback = null,
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
     * @param  array{ candidates: ?array{ array{ content: array{ parts: array{ array{ text: ?string, inlineData: array{ mimeType: string, data: string } } }, role: string }, finishReason: string, safetyRatings: array{ array{ category: string, probability: string, blocked: ?bool } }, citationMetadata: ?array{ citationSources: array{ array{ startIndex: int, endIndex: int, uri: ?string, license: ?string} } }, index: int, tokenCount: ?int, avgLogprobs: ?float } }, promptFeedback: ?array{ safetyRatings: array{ array{ category: string, probability: string, blocked: ?bool } }, blockReason: ?string }, usageMetadata: array{ promptTokenCount: int, candidatesTokenCount: int, totalTokenCount: int, cachedContentTokenCount: ?int } }  $attributes
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
            promptFeedback: $promptFeedback
        );
    }

    public function toArray(): array
    {
        return [
            'candidates' => array_map(
                static fn (Candidate $candidate): array => $candidate->toArray(),
                $this->candidates
            ),
            'usageMetadata' => $this->usageMetadata->toArray(),
            'promptFeedback' => $this->promptFeedback?->toArray(),
        ];
    }
}
