<?php

declare(strict_types=1);

namespace Gemini\Requests\CachedContents;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;

class RetrieveRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $name) {}

    public function resolveEndpoint(): string
    {
        return $this->name;
    }
}
