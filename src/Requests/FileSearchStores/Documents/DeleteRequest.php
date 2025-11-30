<?php

declare(strict_types=1);

namespace Gemini\Requests\FileSearchStores\Documents;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;

/**
 * @link https://ai.google.dev/api/file-search/documents#method:-fileSearchStores.documents.delete
 */
class DeleteRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected readonly string $name,
        protected readonly bool $force = false,
    ) {}

    public function resolveEndpoint(): string
    {
        return $this->name;
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultQuery(): array
    {
        return $this->force ? ['force' => 'true'] : [];
    }
}
