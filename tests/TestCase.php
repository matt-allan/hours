<?php

declare(strict_types=1);

namespace Tests;

use Carbon\CarbonImmutable;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function tearDown(): void
    {
        parent::tearDown();

        CarbonImmutable::setTestNow();
    }
}
