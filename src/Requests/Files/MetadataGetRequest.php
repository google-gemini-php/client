<?php

declare(strict_types=1);

namespace Gemini\Requests\Files;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;
use Psr\Http\Message\RequestInterface;

/**
 * @link https://ai.google.dev/api/files#method:-files.get
 */
class MetadataGetRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::GET;

    /**
     * @param  string  $nameOrUri  Either the just file name or the complete metadata URI from an upload.
     */
    public function __construct(
        protected readonly string $nameOrUri
    ) {}

    public function resolveEndpoint(): string
    {
        if (str_starts_with($this->nameOrUri, 'http')) {
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
