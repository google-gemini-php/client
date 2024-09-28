<?php

declare(strict_types=1);

namespace Gemini\Requests\GenerativeModel;

use Gemini\Concerns\HasContents;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;

class CountTokensRequest extends Request
{
    use HasContents;
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string|Blob|array<string|Blob>|Content>  $parts
     */
    public function __construct(
        protected readonly string $model,
        protected readonly array $parts
    ) {}

    public function resolveEndpoint(): string
    {
        return "{$this->model}:countTokens";
    }

    /**
     * Default body
     *
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'contents' => array_map(
                static fn (Content $content): array => $content->toArray(),
                $this->partsToContents(...$this->parts)
            ),
        ];
    }
}
