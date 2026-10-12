<?php

declare(strict_types=1);

namespace Gemini\Requests\Files;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;
use Psr\Http\Message\RequestInterface;

/**
 * @link https://ai.google.dev/api/files#method:-files.delete
 */
class DeleteRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    /**
     * @param  string  $nameOrUri  The file ID (abc-123), its name (files/abc-123) or the complete URI from an upload.
     */
    public function __construct(
        protected readonly string $nameOrUri
    ) {}

    public function resolveEndpoint(): string
    {
        if (str_starts_with($this->nameOrUri, 'http') || str_starts_with($this->nameOrUri, 'files/')) {
            return $this->nameOrUri;
        }

        return "files/{$this->nameOrUri}";
    }

    public function toRequest(string $baseUrl, array $headers = [], array $queryParams = []): RequestInterface
    {
        if (str_starts_with($this->resolveEndpoint(), 'http')) {
            $baseUrl = '';
        }

        return parent::toRequest($baseUrl, $headers, $queryParams);
    }
}
