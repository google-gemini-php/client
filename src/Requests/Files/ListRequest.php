<?php

declare(strict_types=1);

namespace Gemini\Requests\Files;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;
use Psr\Http\Message\RequestInterface;

/**
 * @link https://ai.google.dev/api/files#method:-files.list
 */
class ListRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "files";
    }

    public function toRequest(string $baseUrl, array $headers = [], array $queryParams = []): RequestInterface
    {
        return parent::toRequest($baseUrl, $headers, $queryParams);
    }
}
