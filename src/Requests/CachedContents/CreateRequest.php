<?php

declare(strict_types=1);

namespace Gemini\Requests\CachedContents;

use Gemini\Concerns\HasContents;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\Tool;
use Gemini\Data\ToolConfig;
use Gemini\Data\UploadedFile;
use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;

class CreateRequest extends Request
{
    use HasContents;
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<Tool>  $tools
     * @param  array<int, string|Blob|array<string|Blob|UploadedFile>|Content|UploadedFile>  $parts
     */
    public function __construct(
        protected readonly string $model,
        protected readonly ?Content $systemInstruction = null,
        protected readonly array $tools = [],
        protected readonly ?ToolConfig $toolConfig = null,
        protected readonly ?string $ttl = null,
        protected readonly ?string $displayName = null,
        /** @var array<int, string|Blob|array<string|Blob|UploadedFile>|Content|UploadedFile> */
        protected array $parts = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return 'cachedContents';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'model' => $this->model,
            'contents' => array_map(
                static fn (Content $c): array => $c->toArray(),
                $this->partsToContents(...$this->parts)
            ),
            'systemInstruction' => $this->systemInstruction?->toArray(),
            'tools' => array_map(static fn (Tool $t): array => $t->toArray(), $this->tools),
            'toolConfig' => $this->toolConfig?->toArray(),
            'ttl' => $this->ttl,
            'displayName' => $this->displayName,
        ], static fn ($v) => $v !== null);
    }
}
