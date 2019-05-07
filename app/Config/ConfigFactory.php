<?php

declare(strict_types=1);

namespace App\Config;

interface ConfigFactory
{
    /**
     * @param string|null $driver
     *
     * @return Repository
     */
    public function driver($driver = null);
}
