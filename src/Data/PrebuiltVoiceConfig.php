<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * The configuration for the prebuilt speaker to use.
 *
 * https://ai.google.dev/api/generate-content#PrebuiltVoiceConfig
 */
final class PrebuiltVoiceConfig implements Arrayable
{
    /**
     * @param  string  $voiceName  The name of the preset voice to use.
     */
    public function __construct(
        public readonly string $voiceName,
    ) {}

    /**
     * @param  array{ voiceName: string }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            voiceName: $attributes['voiceName'],
        );
    }

    public function toArray(): array
    {
        return [
            'voiceName' => $this->voiceName,
        ];
    }
}
