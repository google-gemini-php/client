<?php

declare(strict_types=1);

namespace Gemini\Data;

use InvalidArgumentException;
use stdClass;

/**
 * GoogleSearch tool type. Tool to support Google Search in Model. Powered by Google.
 *
 * https://ai.google.dev/api/caching#GoogleSearch
 */
final class GoogleSearch
{
    /**
     * @param  Interval|null  $timeRangeFilter  Optional. Filter search results to a specific time range. If customers set a start time, they must set an end time (and vice versa).
     *
     * @throws InvalidArgumentException When timeRangeFilter has only startTime or only endTime specified
     */
    public function __construct(
        public readonly ?Interval $timeRangeFilter = null,
    ) {
        if ($this->timeRangeFilter !== null) {
            $hasStartTime = $this->timeRangeFilter->startTime !== null;
            $hasEndTime = $this->timeRangeFilter->endTime !== null;

            // GoogleSearch requires both start and end time to be set together
            if ($hasStartTime !== $hasEndTime) {
                throw new InvalidArgumentException('In GoogleSearch timeRangeFilter, if you set a start time, you must set an end time (and vice versa)');
            }
        }
    }

    /**
     * @param  array{timeRangeFilter?: array{startTime?: ?string, endTime?: ?string}}  $attributes
     */
    public static function from(array $attributes = []): self
    {
        return new self(
            timeRangeFilter: isset($attributes['timeRangeFilter']) ? Interval::from($attributes['timeRangeFilter']) : null,
        );
    }

    /**
     * @return stdClass|array{timeRangeFilter: array{startTime?: ?string, endTime?: ?string}|stdClass}
     */
    public function toArray(): stdClass|array
    {
        if ($this->timeRangeFilter === null) {
            return new stdClass;
        }

        return [
            'timeRangeFilter' => $this->timeRangeFilter->toArray(),
        ];
    }
}
