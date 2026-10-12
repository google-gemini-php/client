<?php

declare(strict_types=1);

namespace Gemini\Requests\Concerns;

trait HasCustomMetadata
{
    /**
     * Converts custom metadata to the API's CustomMetadata format.
     *
     * @param  array<string, string|int|float|array<string>>  $customMetadata
     * @return list<array{ key: string, stringValue?: string, numericValue?: int|float, stringListValue?: array{ values: list<string> } }>
     */
    protected function customMetadataToArray(array $customMetadata): array
    {
        $entries = [];

        foreach ($customMetadata as $key => $value) {
            $entry = ['key' => (string) $key];

            if (is_int($value) || is_float($value)) {
                $entry['numericValue'] = $value;
            } elseif (is_array($value)) {
                $entry['stringListValue'] = ['values' => array_values(array_map('strval', $value))];
            } else {
                $entry['stringValue'] = (string) $value;
            }

            $entries[] = $entry;
        }

        return $entries;
    }
}
