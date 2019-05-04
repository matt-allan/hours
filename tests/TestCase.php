<?php

declare(strict_types=1);

namespace Tests;

use App\Config;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUpTraits()
    {
        parent::setUpTraits();

        $uses = array_flip(class_uses_recursive(static::class));

        if (isset($uses[WithoutConfig::class])) {
            $this->disableConfigForAllTests();
        }
    }

    protected function withoutConfig()
    {
        $this->withConfig(['timezone' => 'UTC']);

        return $this;
    }

    protected function withConfig(array $config)
    {
        $this->app->instance(Config\Repository::class, new Config\MemoryRepository($config));

        return $this;
    }
}
