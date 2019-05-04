<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Config;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class ConfigCommandTest extends TestCase
{
    public function testConfig()
    {
        $this->withTestConfig();

        Storage::fake('config');

        $this
            ->artisan('config time_format \'g:i\'')
            ->assertExitCode(0)->expectsOutput('Updated timeFormat to g:i');

        $this->assertEquals('g:i', $this->app->make(Config::class)->timeFormat);
    }
}
