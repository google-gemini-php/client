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
     * @param  PromptFeedback  $promptFeedback  Returns the prompt's feedback related to the content filters.
     * @param  UsageMetadata  $usageMetadata  Returns the usage metadata for the response.
     */
    public function __construct(
        public readonly array $candidates,
        public readonly ?PromptFeedback $promptFeedback = null,
        public readonly ?UsageMetadata $usageMetadata = null,
    ) {
    }

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
     * @param  array{ candidates: ?array{ array{ content: array{ parts: array{ array{ text: ?string, inlineData: array{ mimeType: string, data: string } } }, role: string }, finishReason: string, safetyRatings: array{ array{ category: string, probability: string, blocked: ?bool } }, citationMetadata: ?array{ citationSources: array{ array{ startIndex: int, endIndex: int, uri: string, license: string} } }, index: int, tokenCount: ?int } }, promptFeedback: ?array{ safetyRatings: array{ array{ category: string, probability: string, blocked: ?bool } }, blockReason: ?string }, usageMetadata: array{promptTokenCount: int, candidatesTokenCount: int, totalTokenCount: int} }  $attributes
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

        $usageMetadata = isset($attributes['usageMetadata'])
            ? UsageMetadata::from($attributes['usageMetadata'])
            : null;

        return new self(
            candidates: $candidates,
            promptFeedback: $promptFeedback,
            usageMetadata: $usageMetadata
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
            'usageMetadata' => $this->usageMetadata?->toArray(),
        ];
    }
}
