<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * The configuration for a single speaker in a multi speaker setup.
 *
 * https://ai.google.dev/api/generate-content#SpeakerVoiceConfig
 */
final class SpeakerVoiceConfig implements Arrayable
{
    /**
     * @param  string  $speaker  Required. The name of the speaker to use. Should be the same as in the prompt.
     * @param  VoiceConfig  $voiceConfig  Required. The configuration for the voice to use.
     */
    public function __construct(
        public readonly string $speaker,
        public readonly VoiceConfig $voiceConfig,
    ) {}

    /**
     * @param  array{ speaker: string, voiceConfig: array{ prebuiltVoiceConfig?: array{ voiceName: string } } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            speaker: $attributes['speaker'],
            voiceConfig: VoiceConfig::from($attributes['voiceConfig']),
        );
    }

    public function toArray(): array
    {
        return [
            'speaker' => $this->speaker,
            'voiceConfig' => $this->voiceConfig->toArray(),
        ];
    }
}
