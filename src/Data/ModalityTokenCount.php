<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use Gemini\Enums\Modality;

/**
 * Metadata on the generation request's token usage.
 *
 * https://ai.google.dev/api/generate-content#modalitytokencount
 */
final class ModalityTokenCount implements Arrayable
{
    /**
     * @param  int  $tokenCount  Number of tokens.
     * @param  Modality|null  $modality  The modality associated with this token count.
     */
    public function __construct(
        public readonly int $tokenCount,
        public readonly ?Modality $modality = null,
    ) {}

    /**
     * @param  array{ modality: string, tokenCount: int}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            tokenCount: $attributes['tokenCount'],
            modality: Modality::tryFrom($attributes['modality']),
        );
    }

    public function toArray(): array
    {
        return [
            'tokenCount' => $this->tokenCount,
            'modality' => $this->modality?->value,
        ];
    }
}
