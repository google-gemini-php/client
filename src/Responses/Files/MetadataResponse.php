<?php

declare(strict_types=1);

namespace Gemini\Responses\Files;

use Gemini\Contracts\ResponseContract;
use Gemini\Data\VideoMetadata;
use Gemini\Enums\FileState;
use Gemini\Testing\Responses\Concerns\Fakeable;

/**
 * @link https://ai.google.dev/api/files#File
 */
class MetadataResponse implements ResponseContract
{
    use Fakeable;

    public function __construct(
        public readonly string $name,
        public readonly string $displayName,
        public readonly string $mimeType,
        public readonly string $sizeBytes,
        public readonly string $createTime,
        public readonly string $updateTime,
        public readonly string $expirationTime,
        public readonly string $sha256Hash,
        public readonly string $uri,
        public readonly FileState $state,
        public readonly ?VideoMetadata $videoMetadata = null,
    ) {}

    /**
     * @param  array{ name: string, displayName: string, mimeType: string, sizeBytes: string, createTime: string, updateTime: string, expirationTime: string, sha256Hash: string, uri: string, state: string, videoMetadata: ?array{ videoDuration: string } }  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: $attributes['name'],
            displayName: $attributes['displayName'],
            mimeType: $attributes['mimeType'],
            sizeBytes: $attributes['sizeBytes'],
            createTime: $attributes['createTime'],
            updateTime: $attributes['updateTime'],
            expirationTime: $attributes['expirationTime'],
            sha256Hash: $attributes['sha256Hash'],
            uri: $attributes['uri'],
            state: FileState::from($attributes['state']),
            videoMetadata: isset($attributes['videoMetadata']) ? VideoMetadata::from($attributes['videoMetadata']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'displayName' => $this->displayName,
            'mimeType' => $this->mimeType,
            'sizeBytes' => $this->sizeBytes,
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
            'expirationTime' => $this->expirationTime,
            'sha256Hash' => $this->sha256Hash,
            'uri' => $this->uri,
            'state' => $this->state->value,
            'videoMetadata' => $this->videoMetadata?->toArray(),
        ];
    }
}
