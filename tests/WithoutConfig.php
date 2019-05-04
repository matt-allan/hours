<?php

declare(strict_types=1);

namespace Tests;

trait WithoutConfig
{
    abstract protected function withoutConfig();

    /**
     * Disable persistent config for this test class.
     */
    public function disableConfigForAllTests()
    {
        $this->withoutConfig();
    }
}
