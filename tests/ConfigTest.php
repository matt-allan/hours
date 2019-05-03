<?php

declare(strict_types=1);

namespace Tests;

use App\Config;
use Illuminate\Support\Facades\Storage;

class ConfigTest extends TestCase
{
    public function testConfig()
    {
        $config = new Config(
            $dateFormat = 'Y-M-d',
            $timeFormat = 'H:i:s',
            $intervalFormat = '%h:%I',
            $timezone = '+04:30'
        );

        $this->assertEquals($dateFormat, $config->dateFormat);
        $this->assertEquals($timeFormat, $config->timeFormat);
        $this->assertEquals($intervalFormat, $config->intervalFormat);
        $this->assertEquals($timezone, $config->timezone);
    }

    public function testSerialization()
    {
        $config = new Config();

        $serialized = $config->toJson();

        $deserialized = Config::fromJson($serialized);

        $this->assertEquals($config, $deserialized);
    }

    public function testGetCreatesConfigIfNecessary()
    {
        Storage::fake('config');

        Config::get();

        Storage::disk('config')->assertExists('config.json');
    }

    public function testSave()
    {
        Storage::fake('config');

        $config = new Config(
            'Y-M-d',
            'H:i:s',
            '%h:%I',
            '+04:30'
        );

        $config->save();

        Storage::disk('config')->assertExists('config.json');

        $stored = Config::get();

        $this->assertEquals($config, $stored);
    }
}
