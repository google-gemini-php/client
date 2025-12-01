<?php

use Gemini\Data\FileSearch;
use Gemini\Data\GoogleMaps;
use Gemini\Data\Tool;

test('to array', function () {
    $tool = new Tool(
        googleMaps: new GoogleMaps,
        fileSearch: new FileSearch(fileSearchStoreNames: ['test-store']),
    );

    expect($tool->toArray())
        ->toEqual([
            'googleMaps' => new stdClass,
            'fileSearch' => [
                'fileSearchStoreNames' => ['test-store'],
            ],
        ]);
});

test('to array with google maps arguments', function () {
    $tool = new Tool(
        googleMaps: new GoogleMaps(enableWidget: true),
    );

    expect($tool->toArray())
        ->toEqual([
            'googleMaps' => ['enableWidget' => true],
        ]);
});

test('to array with file search arguments', function () {
    $tool = new Tool(
        fileSearch: new FileSearch(
            fileSearchStoreNames: ['test-store-2'],
            metadataFilter: 'author = "Robert Graves"'
        ),
    );

    expect($tool->toArray())
        ->toEqual([
            'fileSearch' => [
                'fileSearchStoreNames' => ['test-store-2'],
                'metadataFilter' => 'author = "Robert Graves"',
            ],
        ]);
});
