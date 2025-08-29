<?php

declare(strict_types=1);

namespace Gemini\Requests\CachedContents;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use InvalidArgumentException;

class DeleteRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(protected readonly string $name)
    {
        if ($name === '') {
            throw new InvalidArgumentException('Name cannot be empty');
        }

        if (! preg_match('/^[a-zA-Z0-9\/_-]+$/', $name)) {
            throw new InvalidArgumentException('Name contains invalid characters');
        }
    }

    public function resolveEndpoint(): string
    {
        return $this->name;
    }
}
