<?php

declare(strict_types=1);

namespace Gemini\Requests\CachedContents;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;

class ListRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly ?int $pageSize = null,
        protected readonly ?string $pageToken = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'cachedContents';
    }

    public function defaultQuery(): array
    {
        return array_filter([
            'pageSize' => $this->pageSize,
            'pageToken' => $this->pageToken,
        ], static fn ($v) => $v !== null);
    }
}
