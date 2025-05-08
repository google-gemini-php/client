<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Attribution for a source that contributed to an answer.
 *
 * https://ai.google.dev/api/generate-content#GroundingAttribution
 */
final class GroundingAttribution implements Arrayable
{
    /**
     * @param  AttributionSourceId  $sourceId  Output only. Identifier for the source contributing to this attribution.
     * @param  Content  $content  Grounding source content that makes up this attribution.
     */
    public function __construct(
        public readonly AttributionSourceId $sourceId,
        public readonly Content $content,
    ) {}

    /**
     * @param  array{ sourceId: array{ groundingPassage?: array{ passageId: string, partIndex: int }, semanticRetrieverChunk?: array{ source: string, chunk: string } }, content: array{ parts: array{ array{ text: ?string, inlineData: ?array{ mimeType: string, data: string }, fileData: ?array{ fileUri: string, mimeType: string }, functionCall: ?array{ name: string, args: array<string, mixed>|null }, functionResponse: ?array{ name: string, response: array<string, mixed> } } }, role: string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            sourceId: AttributionSourceId::from($attributes['sourceId']),
            content: Content::from($attributes['content']),
        );
    }

    public function toArray(): array
    {
        return [
            'sourceId' => $this->sourceId,
            'content' => $this->content,
        ];
    }
}
