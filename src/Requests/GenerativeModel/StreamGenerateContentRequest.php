<?php

declare(strict_types=1);

namespace Gemini\Requests\GenerativeModel;

use Gemini\Concerns\HasContents;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\SafetySetting;
use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;

/**
 * https://ai.google.dev/api/rest/v1/models/streamGenerateContent
 */
class StreamGenerateContentRequest extends Request
{
    use HasContents;
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string|Blob|array<string|Blob>|Content>  $parts
     * @param  array<SafetySetting>  $safetySettings
     */
    public function __construct(
        protected readonly string $model,
        protected readonly array $parts,
        protected readonly array $safetySettings = [],
        protected readonly ?GenerationConfig $generationConfig = null
    ) {}

    public function resolveEndpoint(): string
    {
        return "{$this->model}:streamGenerateContent";
    }

    /**
     * Default body
     *
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'contents' => array_map(
                static fn (Content $content): array => $content->toArray(),
                $this->partsToContents(...$this->parts)
            ),
            'safetySettings' => array_map(
                static fn (SafetySetting $setting): array => $setting->toArray(),
                $this->safetySettings ?? []
            ),
            'generationConfig' => $this->generationConfig?->toArray(),
        ];
    }
}
