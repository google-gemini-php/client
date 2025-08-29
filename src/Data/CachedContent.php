<?php

declare(strict_types=1);

namespace Gemini\Data;

use Gemini\Contracts\Arrayable;
use InvalidArgumentException;

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

        if (! is_string($attributes['name'] ?? null)) {
            throw new InvalidArgumentException('Name must be a string');
        }

        if (! is_string($attributes['model'] ?? null)) {
            throw new InvalidArgumentException('Model must be a string');
        }

        if (isset($attributes['displayName']) && ! is_string($attributes['displayName'])) {
            throw new InvalidArgumentException('DisplayName must be a string');
        }

        if (! is_array($attributes['usageMetadata'] ?? null)) {
            throw new InvalidArgumentException('UsageMetadata must be an array');
        }

        if (! is_string($attributes['createTime'] ?? null)) {
            throw new InvalidArgumentException('CreateTime must be a string');
        }

        if (! is_string($attributes['updateTime'] ?? null)) {
            throw new InvalidArgumentException('UpdateTime must be a string');
        }

        if (! is_string($attributes['expireTime'] ?? null)) {
            throw new InvalidArgumentException('ExpireTime must be a string');
        }

        $name = $attributes['name'];
        $model = $attributes['model'];
        /** @var string|null $displayName */
        $displayName = $attributes['displayName'] ?? null;

        /**
         * @var array{
         *     promptTokenCount: int,
         *     totalTokenCount: int,
         *     candidatesTokenCount: ?int,
         *     cachedContentTokenCount: ?int,
         *     toolUsePromptTokenCount: ?int,
         *     thoughtsTokenCount: ?int,
         *     promptTokensDetails: list<array{modality: string, tokenCount: int}>|null,
         *     cacheTokensDetails: list<array{modality: string, tokenCount: int}>|null,
         *     candidatesTokensDetails: list<array{modality: string, tokenCount: int}>|null,
         *     toolUsePromptTokensDetails: list<array{modality: string, tokenCount: int}>|null
         * } $usageMetadataData
         */
        $usageMetadataData = $attributes['usageMetadata'];
        $usageMetadata = UsageMetadata::from($usageMetadataData);
        $createTime = $attributes['createTime'];
        $updateTime = $attributes['updateTime'];
        $expireTime = $attributes['expireTime'];

        return new self(
            name: $name,
            model: $model,
            displayName: $displayName,
            usageMetadata: $usageMetadata,
            createTime: $createTime,
            updateTime: $updateTime,
            expireTime: $expireTime,
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
