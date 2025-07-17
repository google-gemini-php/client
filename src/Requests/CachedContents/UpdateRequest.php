<?php

declare(strict_types=1);

namespace Gemini\Requests\CachedContents;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;
use InvalidArgumentException;

class UpdateRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected readonly string $name,
        protected readonly ?string $ttl = null,
        protected readonly ?string $expireTime = null,
    ) {
        if ($name === '') {
            throw new InvalidArgumentException('Name cannot be empty');
        }

        if (! preg_match('/^[a-zA-Z0-9\/_-]+$/', $name)) {
            throw new InvalidArgumentException('Name contains invalid characters');
        }

        if ($ttl !== null && ! preg_match('/^\d+(?:\.\d{1,9})?s?$/', $ttl)) {
            throw new InvalidArgumentException('TTL must be a duration in seconds (e.g., "60s", "120.5s")');
        }
    }

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
