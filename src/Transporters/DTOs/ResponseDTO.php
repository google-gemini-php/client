<?php

declare(strict_types=1);

namespace Gemini\Transporters\DTOs;

/**
 * @template-covariant TData of array
 *
 * @internal
 */
final class ResponseDTO
{
    /**
     * Creates a new ResponseDTO value object.
     *
     * @param  TData  $data
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Creates a new ResponseDTO value object from the given data.
     *
     * @param  TData  $data
     * @return ResponseDTO<TData>
     */
    public static function from(array $data): self
    {
        return new self(
            data: $data
        );
    }

    /**
     * Returns the response data.
     *
     * @return TData
     */
    public function data(): array
    {
        return $this->data;
    }
}
