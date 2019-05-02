<?php

declare(strict_types=1);

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class Config implements Arrayable, Jsonable
{
    const PATH = 'config.json';

    /**
     * The date format to use.
     *
     * @var string
     */
    public $dateFormat;

    /**
     * The time format to use.
     *
     * @var string
     */
    public $timeFormat;

    /**
     * Either an offset or a recognized timezone identifier.
     *
     * @var string
     */
    public $timezone;

    public function __construct(?string $dateFormat = 'F j, Y', ?string $timeFormat = 'g:i a', ?string $timezone = null)
    {
        $this->dateFormat = $dateFormat ?? 'F j, Y';
        $this->timeFormat = $timeFormat ?? 'g:i a';
        $this->timezone = $timezone ?? $this->guessTimezone();
    }

    public static function get(): self
    {
        if (! Storage::disk('config')->exists(self::PATH)) {
            return tap(new self(), function (self $config) {
                $config->save();
            });
        }

        return self::fromJson(Storage::disk('config')->get(self::PATH));
    }

    public function save(): bool
    {
        return Storage::disk('config')->put(self::PATH, $this->toJson(JSON_PRETTY_PRINT));
    }

    public static function fromJson(string $json): self
    {
        $items = json_decode($json, true);

        if (! $items || json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON: '.json_last_error_msg());
        }

        return new self(
            Arr::get($items, 'date_format'),
            Arr::get($items, 'time_format'),
            Arr::get($items, 'timezone')
        );
    }

    public function toArray(): array
    {
        return [
           'date_format' => $this->dateFormat,
           'time_format' => $this->timeFormat,
           'timezone' => $this->timezone,
        ];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    private function guessTimezone(): ?string
    {
        if (PHP_OS_FAMILY === 'win') {
            // TODO: something like `systeminfo | findstr ”Time Zone”`
            return 'UTC';
        }

        $timezone = exec('date +%z');

        if (strlen($timezone) !== 5) {
            return 'UTC';
        }

        // date returns a format like '-0400' but PHP expects a format like '-04:00'.
        return substr($timezone, 0, 3).':'.substr($timezone, 3);
    }
}
