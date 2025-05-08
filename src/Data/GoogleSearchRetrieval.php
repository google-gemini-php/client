<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Tool to retrieve public web data for grounding, powered by Google.
 *
 * https://ai.google.dev/api/caching#GoogleSearchRetrieval
 */
final class GoogleSearchRetrieval implements Arrayable
{
    /**
     * @param  DynamicRetrievalConfig  $dynamicRetrievalConfig  Specifies the dynamic retrieval configuration for the given source.
     */
    public function __construct(
        public readonly DynamicRetrievalConfig $dynamicRetrievalConfig,
    ) {}

    /**
     * @param  array{ dynamicRetrievalConfig: array{ mode: string, dynamicThreshold: float } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            dynamicRetrievalConfig: DynamicRetrievalConfig::from($attributes['dynamicRetrievalConfig']),
        );
    }

    public function toArray(): array
    {
        return [
            'dynamicRetrievalConfig' => $this->dynamicRetrievalConfig->toArray(),
        ];
    }
}
