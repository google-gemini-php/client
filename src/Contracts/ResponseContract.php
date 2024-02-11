<?php

declare(strict_types=1);

namespace Gemini\Contracts;

interface ResponseContract extends Arrayable
{
    /**
     * @param  array<mixed>  $attributes
     */
    public static function from(array $attributes): self;
}
