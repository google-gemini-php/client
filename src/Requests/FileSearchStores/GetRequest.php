<?php

declare(strict_types=1);

namespace Gemini\Requests\FileSearchStores;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;

/**
 * @link https://ai.google.dev/api/file-search/file-search-stores#method:-fileSearchStores.get
 */
class GetRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return $this->name;
    }
}
