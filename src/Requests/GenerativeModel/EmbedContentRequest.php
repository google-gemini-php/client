<?php

declare(strict_types=1);

namespace Gemini\Requests\GenerativeModel;

use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Enums\Method;
use Gemini\Enums\TaskType;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;

class EmbedContentRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string|Blob|array<string|Blob>|Content  $part
     */
    public function __construct(
        protected readonly string $model,
        protected readonly string|Blob|array|Content $part,
        protected readonly ?TaskType $taskType = null,
        protected readonly ?string $title = null
    ) {}

    public function resolveEndpoint(): string
    {
        return "{$this->model}:embedContent";
    }

    /**
     * Default body
     *
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'content' => Content::parse(part: $this->part)->toArray(),
            'taskType' => $this->taskType?->value,
            'title' => $this->title,
        ];
    }
}
