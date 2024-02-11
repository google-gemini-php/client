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

    public function resolveEndpoint(): string
    {
        return 'models';
    }
}
