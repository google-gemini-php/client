<?php

declare(strict_types=1);

namespace Gemini\Requests\GenerativeModel;

use Gemini\Concerns\HasContents;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;

class BatchEmbedContentRequest extends Request
{
    use HasContents;
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $model  The model's resource name. This serves as an ID for the Model to use.
     * @param  array<string|Blob|array<string|Blob>|Content|EmbedContentRequest>  $parts
     */
    public function __construct(
        protected readonly string $model,
        protected readonly array $parts,
    ) {}

    public function resolveEndpoint(): string
    {
        return "{$this->model}:batchEmbedContents";
    }

    /**
     * Default body
     *
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'requests' => array_map(
                fn (EmbedContentRequest|string|Blob|array|Content $part) => [
                    'model' => $this->model,
                    ...match (true) {
                        $part instanceof EmbedContentRequest => $part->body(),
                        default => (new EmbedContentRequest(
                            model: $this->model,
                            part: $part
                        ))->body(),
                    },
                ],
                $this->parts
            ),
        ];
    }
}
