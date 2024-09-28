<?php

declare(strict_types=1);

namespace Gemini\Responses\GenerativeModel;

use Gemini\Contracts\ResponseContract;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * https://ai.google.dev/api/rest/v1/models/countTokens#response-body
 */
final class CountTokensResponse implements ResponseContract
{
    use Fakeable;

    private function __construct(
        public readonly int $totalTokens,
    ) {}

    /**
     * @param  array{ totalTokens: int }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(totalTokens: intval($attributes['totalTokens']));
    }

    public function toArray(): array
    {
        return [
            'totalTokens' => $this->totalTokens,
        ];
    }
}
