<?php

declare(strict_types=1);

namespace Gemini\Requests\FileSearchStores;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;

/**
 * @link https://ai.google.dev/api/file-search/file-search-stores#method:-fileSearchStores.list
 */
class ListRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  int|null  $pageSize  Maximum number of FileSearchStores to return per page. If unspecified, defaults to 10. Maximum pageSize is 20.
     * @param  string|null  $nextPageToken  A page token from a previous fileSearchStores.list call.
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
        return 'fileSearchStores';
    }
}
