<?php

declare(strict_types=1);

namespace Gemini\Requests\FileSearchStores;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;

/**
 * @link https://ai.google.dev/api/file-search/file-search-stores#method:-fileSearchStores.create
 */
class CreateRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public ?string $displayName = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'fileSearchStores';
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        $body = [];

        if ($this->displayName !== null) {
            $body['displayName'] = $this->displayName;
        }

        return $body;
    }
}
