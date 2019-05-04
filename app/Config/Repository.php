<?php

declare(strict_types=1);

namespace App\Config;

interface Repository
{
    public function get(string $key, $default = null);

    public function set(string $key, $value): self;
}
