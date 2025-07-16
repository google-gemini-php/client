<?php

declare(strict_types=1);

namespace Gemini\Requests\CachedContents;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;

class UpdateRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected readonly string $name,
        protected readonly ?string $ttl = null,
        protected readonly ?string $expireTime = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return $this->name;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'ttl' => $this->ttl,
            'expireTime' => $this->expireTime,
        ], static fn ($v) => $v !== null);
    }
}
