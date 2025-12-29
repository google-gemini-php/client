<?php

declare(strict_types=1);

namespace Gemini\Requests\FileSearchStores;

use Gemini\Enums\Method;
use Gemini\Enums\MimeType;
use Gemini\Foundation\Request;
use Http\Discovery\Psr17Factory;
use Psr\Http\Message\RequestInterface;

/**
 * @link https://ai.google.dev/api/file-search/file-search-stores#method:-media.uploadtofilesearchstore
 */
class UploadRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  array<string, string|int|float|array<string>>  $customMetadata
     */
    public function __construct(
        protected readonly string $storeName,
        protected readonly string $filename,
        protected readonly ?string $displayName = null,
        protected ?MimeType $mimeType = null,
        protected array $customMetadata = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return $this->storeName.':uploadToFileSearchStore';
    }

    public function toRequest(string $baseUrl, array $headers = [], array $queryParams = []): RequestInterface
    {
        $factory = new Psr17Factory;
        $boundary = rand(111111, 999999);

        $metadata = [];
        if ($this->displayName) {
            $metadata['displayName'] = $this->displayName;
        }
        if ($this->mimeType) {
            $metadata['mimeType'] = $this->mimeType->value;
        }

        if (! empty($this->customMetadata)) {
            $metadata['customMetadata'] = [];
            foreach ($this->customMetadata as $key => $value) {
                $entry = ['key' => (string) $key];

                if (is_int($value) || is_float($value)) {
                    $entry['numericValue'] = $value;
                } elseif (is_array($value)) {
                    $entry['stringListValue'] = ['values' => array_map('strval', $value)];
                } else {
                    $entry['stringValue'] = (string) $value;
                }

                $metadata['customMetadata'][] = $entry;
            }
        }

        $requestJson = empty($metadata) ? '' : json_encode($metadata);
        $contents = file_get_contents($this->filename);
        if ($contents === false) {
            throw new \RuntimeException("Failed to read file: {$this->filename}");
        }

        $request = $factory
            ->createRequest(
                $this->method->value,
                preg_replace('#/v1(beta)?#', '/upload/v1$1', $baseUrl).$this->resolveEndpoint()
            )
            ->withHeader('X-Goog-Upload-Protocol', 'multipart');
        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        $contentType = $this->mimeType instanceof MimeType ? $this->mimeType->value : (mime_content_type($this->filename) ?: 'application/octet-stream');

        $request = $request->withHeader('Content-Type', "multipart/related; boundary={$boundary}")
            ->withBody($factory->createStream(<<<BOD
--{$boundary}
Content-Type: application/json; charset=utf-8

{$requestJson}
--{$boundary}
Content-Type: {$contentType}

{$contents}
--{$boundary}--
BOD));

        return $request;
    }
}
