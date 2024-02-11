<?php

declare(strict_types=1);

namespace Gemini\Requests\Concerns;

use Psr\Http\Message\RequestInterface;

trait HasJsonBody
{
    /**
     * Boot the plugin
     */
    public function bootHasJsonBody(RequestInterface $request): void
    {
        $request->withHeader('Content-Type', 'application/json');
    }

    /**
     * @return array<array-key, mixed>
     */
    public function body(): array
    {
        return $this->defaultBody();
    }

    /**
     * Default body
     *
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [];
    }
}
