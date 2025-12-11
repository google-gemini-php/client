<?php

declare(strict_types=1);

namespace Gemini\Data;

use DateTime;
use InvalidArgumentException;
use stdClass;

/**
 * Represents a time interval, encoded as a Timestamp start (inclusive) and a Timestamp end (exclusive).
 *
 * The start must be less than or equal to the end. When the start equals the end, the interval is empty (matches no time). When both start and end are unspecified, the interval matches any time.
 *
 * https://ai.google.dev/api/caching#Interval
 */
final class Interval
{
    /**
     * @param  ?string  $startTime  Optional. Inclusive start of the interval. If specified, a Timestamp matching this interval will have to be the same or after the start. Uses RFC 3339 format. Examples: "2014-10-02T15:01:23Z", "2014-10-02T15:01:23.045123456Z" or "2014-10-02T15:01:23+05:30".
     * @param  ?string  $endTime  Optional. Exclusive end of the interval. If specified, a Timestamp matching this interval will have to be before the end. Uses RFC 3339 format. Examples: "2014-10-02T15:01:23Z", "2014-10-02T15:01:23.045123456Z" or "2014-10-02T15:01:23+05:30".
     *
     * @throws InvalidArgumentException When timestamp format is invalid or start time is after end time
     */
    public function __construct(
        public readonly ?string $startTime,
        public readonly ?string $endTime,
    ) {
        if ($this->startTime !== null && ! $this->isValidTimestamp($this->startTime)) {
            throw new InvalidArgumentException('startTime must be in RFC 3339 timestamp format');
        }

        if ($this->endTime !== null && ! $this->isValidTimestamp($this->endTime)) {
            throw new InvalidArgumentException('endTime must be in RFC 3339 timestamp format');
        }

        if ($this->startTime !== null && $this->endTime !== null) {
            $startTimestamp = strtotime($this->startTime);
            $endTimestamp = strtotime($this->endTime);

            if ($startTimestamp === false || $endTimestamp === false) {
                throw new InvalidArgumentException('Invalid timestamp format');
            }

            if ($startTimestamp > $endTimestamp) {
                throw new InvalidArgumentException('startTime must be less than or equal to endTime');
            }
        }
    }

    /**
     * @param  array{startTime?: ?string, endTime?: ?string}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self($attributes['startTime'] ?? null, $attributes['endTime'] ?? null);
    }

    /**
     * @return stdClass|array{startTime?: ?string, endTime?: ?string}
     */
    public function toArray(): stdClass|array
    {
        $data = [];

        if ($this->startTime !== null) {
            $data['startTime'] = $this->startTime;
        }

        if ($this->endTime !== null) {
            $data['endTime'] = $this->endTime;
        }

        return empty($data) ? new stdClass : $data;
    }

    /**
     * Validates if a string is in RFC 3339 timestamp format
     */
    private function isValidTimestamp(string $timestamp): bool
    {
        // RFC 3339 regex pattern
        $pattern = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d{1,9})?(Z|[+-]\d{2}:\d{2})$/';

        if (! preg_match($pattern, $timestamp)) {
            return false;
        }

        // Handle Z timezone suffix by converting to +00:00
        $normalizedTimestamp = str_replace('Z', '+00:00', $timestamp);

        // Try with extended format first (includes microseconds)
        $dateTime = DateTime::createFromFormat(DateTime::RFC3339_EXTENDED, $normalizedTimestamp);
        if ($dateTime === false) {
            // Try with standard RFC3339 format
            $dateTime = DateTime::createFromFormat(DateTime::RFC3339, $normalizedTimestamp);
        }

        return $dateTime !== false;
    }
}
