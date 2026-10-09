<?php

use Gemini\Data\GenerationConfig;
use Gemini\Data\ImageConfig;

test('to array', function () {
    $imageConfig = new ImageConfig(aspectRatio: '16:9', imageSize: '2K');

    expect($imageConfig->toArray())
        ->toBe([
            'aspectRatio' => '16:9',
            'imageSize' => '2K',
        ]);
});

test('to array with aspect ratio only', function () {
    expect((new ImageConfig('16:9'))->toArray())
        ->toBe([
            'aspectRatio' => '16:9',
        ]);
});

test('to array with image size only', function () {
    expect((new ImageConfig(imageSize: '4K'))->toArray())
        ->toBe([
            'imageSize' => '4K',
        ]);
});

test('from', function () {
    expect(ImageConfig::from(['aspectRatio' => '1:1', 'imageSize' => '512']))
        ->aspectRatio->toBe('1:1')
        ->imageSize->toBe('512')
        ->and(ImageConfig::from([]))
        ->aspectRatio->toBeNull()
        ->imageSize->toBeNull();
});

test('generation config with image config', function () {
    expect((new GenerationConfig(imageConfig: new ImageConfig(imageSize: '2K')))->toArray())
        ->imageConfig->toBe(['imageSize' => '2K'])
        ->and((new GenerationConfig(imageConfig: new ImageConfig))->toArray())
        ->not->toHaveKey('imageConfig');
});
