<?php

declare(strict_types=1);

namespace Gemini\Requests\Files;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;
use Gemini\Requests\Concerns\HasJsonBody;

/**
 * @link https://ai.google.dev/api/files#method:-files.list
 */
class ListRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::GET;

    /**
     * @param  int|null  $pageSize  Maximum number of Files to return per page. If unspecified, defaults to 10. Maximum pageSize is 100.
     * @param  string|null  $nextPageToken  A page token from a previous files.list call.
     */
    public function __construct(
        public ?int $pageSize = null,
        public ?string $nextPageToken = null,
    ) {}

    public function defaultQuery(): array
    {
        $query = [];

        if ($this->pageSize !== null) {
            $query['pageSize'] = $this->pageSize;
        }

        if ($this->nextPageToken !== null) {
            $query['pageToken'] = $this->nextPageToken;
        }

        return $query;
    }

    public function resolveEndpoint(): string
    {
        return 'files';
    }
}
