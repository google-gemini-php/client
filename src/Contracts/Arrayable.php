<?php

declare(strict_types=1);

namespace Gemini\Contracts;

interface Arrayable
{
    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}
