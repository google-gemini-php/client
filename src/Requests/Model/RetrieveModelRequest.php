<?php

declare(strict_types=1);

namespace Gemini\Requests\Model;

use Gemini\Enums\Method;
use Gemini\Foundation\Request;

/**
 * https://ai.google.dev/api/rest/v1/models/get
 */
class RetrieveModelRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $model) {}

    public function resolveEndpoint(): string
    {
        return $this->model;
    }
}
