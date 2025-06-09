<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * The speech generation config.
 *
 * https://ai.google.dev/api/generate-content#SpeechConfig
 */
final class SpeechConfig implements Arrayable
{
    /**
     * @param  VoiceConfig|null  $voiceConfig  The configuration in case of single-voice output.
     * @param  MultiSpeakerVoiceConfig|null  $multiSpeakerVoiceConfig  Optional. The configuration for the multi-speaker setup. It is mutually exclusive with the voiceConfig field.
     * @param  string|null  $languageCode  Optional. Language code (in BCP 47 format, e.g. "en-US") for speech synthesis. Valid values are: de-DE, en-AU, en-GB, en-IN, en-US, es-US, fr-FR, hi-IN, pt-BR, ar-XA, es-ES, fr-CA, id-ID, it-IT, ja-JP, tr-TR, vi-VN, bn-IN, gu-IN, kn-IN, ml-IN, mr-IN, ta-IN, te-IN, nl-NL, ko-KR, cmn-CN, pl-PL, ru-RU, and th-TH.
     */
    public function __construct(
        public readonly ?VoiceConfig $voiceConfig = null,
        public readonly ?MultiSpeakerVoiceConfig $multiSpeakerVoiceConfig = null,
        public readonly ?string $languageCode = null,
    ) {}

    /**
     * @param  array{ voiceConfig?: array{ prebuiltVoiceConfig?: array{ voiceName: string } }, multiSpeakerVoiceConfig?: array{ speakerVoiceConfigs: array<array{ speaker: string, voiceConfig: array{ prebuiltVoiceConfig?: array{ voiceName: string } } }> }, languageCode?: string}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            voiceConfig: isset($attributes['voiceConfig']) ? VoiceConfig::from($attributes['voiceConfig']) : null,
            multiSpeakerVoiceConfig: isset($attributes['multiSpeakerVoiceConfig']) ? MultiSpeakerVoiceConfig::from($attributes['multiSpeakerVoiceConfig']) : null,
            languageCode: $attributes['languageCode'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'voiceConfig' => $this->voiceConfig?->toArray(),
            'multiSpeakerVoiceConfig' => $this->multiSpeakerVoiceConfig?->toArray(),
            'languageCode' => $this->languageCode,
        ];
    }
}
