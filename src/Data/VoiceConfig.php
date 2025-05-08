<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * The configuration for the voice to use.
 *
 * https://ai.google.dev/api/generate-content#VoiceConfig
 */
final class VoiceConfig implements Arrayable
{
    /**
     * @param  PrebuiltVoiceConfig|null  $prebuiltVoiceConfig  The configuration for the prebuilt voice to use.
     */
    public function __construct(
        public readonly ?PrebuiltVoiceConfig $prebuiltVoiceConfig = null,
    ) {}

    /**
     * @param  array{ prebuiltVoiceConfig?: array{ voiceName: string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            prebuiltVoiceConfig: isset($attributes['prebuiltVoiceConfig']) ? PrebuiltVoiceConfig::from($attributes['prebuiltVoiceConfig']) : null,
        );
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->prebuiltVoiceConfig !== null) {
            $data['prebuiltVoiceConfig'] = $this->prebuiltVoiceConfig->toArray();
        }

        return $data;
    }
}
