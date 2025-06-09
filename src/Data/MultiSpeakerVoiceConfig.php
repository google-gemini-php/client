<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * The configuration for a single speaker in a multi speaker setup.
 *
 * https://ai.google.dev/api/generate-content#MultiSpeakerVoiceConfig
 */
final class MultiSpeakerVoiceConfig implements Arrayable
{
    /**
     * @param  array<SpeakerVoiceConfig>  $speakerVoiceConfigs  Required. All the enabled speaker voices.
     */
    public function __construct(
        public readonly array $speakerVoiceConfigs,
    ) {}

    /**
     * @param  array{ speakerVoiceConfigs: array<array{ speaker: string, voiceConfig: array{ prebuiltVoiceConfig?: array{ voiceName: string } } }> }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            speakerVoiceConfigs: array_map(
                static fn (array $speakerVoiceConfig): SpeakerVoiceConfig => SpeakerVoiceConfig::from($speakerVoiceConfig),
                $attributes['speakerVoiceConfigs'],
            )
        );
    }

    public function toArray(): array
    {
        return [
            'speakerVoiceConfigs' => array_map(
                static fn (SpeakerVoiceConfig $speakerVoiceConfig): array => $speakerVoiceConfig->toArray(),
                $this->speakerVoiceConfigs,
            ),
        ];
    }
}
