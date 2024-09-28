<?php

declare(strict_types=1);

namespace Gemini\Requests\Model;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;

/**
 * https://ai.google.dev/api/rest/v1/models/list
 */
class ListModelRequest extends Request
{
    public Method $method = Method::GET;

    /**
     * @param  int|null  $pageSize  The maximum number of Models to return (per page).
     * @param  string|null  $nextPageToken  A page token, received from a previous models.list call.
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
        return 'models';
    }
}
