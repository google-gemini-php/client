<?php

declare(strict_types=1);

namespace Gemini\Requests\Files;

use Gemini\Enums\Method;
use Gemini\Enums\MimeType;
use Gemini\Foundation\Request;
use Http\Discovery\Psr17Factory;
use Psr\Http\Message\RequestInterface;

/**
 * @link https://ai.google.dev/api/files#method:-media.upload
 */
class UploadRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $filename,
        protected readonly string $displayName,
        protected MimeType $mimeType,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'files';
    }

    public function toRequest(string $baseUrl, array $headers = [], array $queryParams = []): RequestInterface
    {
        $factory = new Psr17Factory;
        $boundary = rand(111111, 999999);
        $requestJson = json_encode(['file' => ['display_name' => $this->displayName]]);
        $contents = file_get_contents($this->filename);

        $request = $factory
            ->createRequest($this->method->value, str_replace('/v1', '/upload/v1', $baseUrl).$this->resolveEndpoint())
            ->withHeader('X-Goog-Upload-Protocol', 'multipart');
        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }
        $request = $request->withHeader('Content-Type', "multipart/related; boundary={$boundary}")
            ->withBody($factory->createStream(<<<BOD
--{$boundary}
Content-Type: application/json; charset=utf-8

{$requestJson}
--{$boundary}
Content-Type: {$this->mimeType->value}

{$contents}
--{$boundary}--
BOD));

        return $request;
    }
}
