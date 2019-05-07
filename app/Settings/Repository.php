<?php

declare(strict_types=1);

namespace App\Settings;

use Illuminate\Support\Collection;

interface Repository
{
    public function get(string $key, $default = null);

    public function set(string $key, $value): self;

    public function all(): Collection;
}
