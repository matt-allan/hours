<?php

declare(strict_types=1);

namespace Tests;

use App\Config;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function withTestConfig(?Config $config = null): self
    {
        $this->app->instance(Config::class, $config ?? new Config('F j, Y', 'g:i a', '%h:%I', 'America/New_York'));

        return $this;
    }
}
