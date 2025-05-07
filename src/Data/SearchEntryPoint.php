<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Google search entry point
 *
 * https://ai.google.dev/gemini-api/docs/grounding?configure-search&lang=rest#grounded-response
 */
final class SearchEntryPoint implements Arrayable
{
    /**
     * @param string $renderedContent Web content snippet that can be embedded in a web page or an app webview
     * @param string $sdkBlob Base64 encoded JSON representing array of tuple
     */
    public function __construct(
        public readonly ?string $renderedContent = null,
        public readonly ?string $sdkBlob = null,
    ) {}

    /**
     * @param  array{ renderedContent: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            renderedContent: $attributes['renderedContent'] ?? null,
            sdkBlob: $attributes['sdkBlob'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'renderedContent' => $this->renderedContent,
            'sdkBlob' => $this->sdkBlob,
        ];
    }
}
