<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;

/**
 * Metadata about cached content.
 *
 * @link https://ai.google.dev/api/caching#CachedContent
 */
final class CachedContent implements Arrayable
{
    public function __construct(
        public readonly string $name,
        public readonly string $model,
        public readonly ?string $displayName,
        public readonly UsageMetadata $usageMetadata,
        public readonly string $createTime,
        public readonly string $updateTime,
        public readonly string $expireTime,
    ) {}

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            name: (string) $attributes['name'],
            model: (string) $attributes['model'],
            displayName: isset($attributes['displayName']) ? (string) $attributes['displayName'] : null,
            usageMetadata: UsageMetadata::from($attributes['usageMetadata']),
            createTime: (string) $attributes['createTime'],
            updateTime: (string) $attributes['updateTime'],
            expireTime: (string) $attributes['expireTime'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'model' => $this->model,
            'displayName' => $this->displayName,
            'usageMetadata' => $this->usageMetadata->toArray(),
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
            'expireTime' => $this->expireTime,
        ];
    }
}
