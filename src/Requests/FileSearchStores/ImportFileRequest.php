<?php

declare(strict_types=1);

namespace Gemini\Requests\FileSearchStores;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasCustomMetadata;
use Gemini\Requests\Concerns\HasJsonBody;

/**
 * @link https://ai.google.dev/api/file-search/file-search-stores#method:-fileSearchStores.importfile
 */
class ImportFileRequest extends Request
{
    use HasCustomMetadata;
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, string|int|float|array<string>>  $customMetadata
     */
    public function __construct(
        protected readonly string $storeName,
        protected readonly string $fileName,
        protected readonly array $customMetadata = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return $this->storeName.':importFile';
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        $body = ['fileName' => $this->fileName];

        if ($this->customMetadata !== []) {
            $body['customMetadata'] = $this->customMetadataToArray($this->customMetadata);
        }

        return $body;
    }
}
