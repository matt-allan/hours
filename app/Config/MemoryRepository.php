<?php

declare(strict_types=1);

namespace App\Config;

class MemoryRepository implements Repository
{
    private $items;

    public function __construct($items = [])
    {
        $this->items = collect($items);
    }

    public function get(string $key, $default = null)
    {
        return $this->items->get($key, $default);
    }

    public function set(string $key, $value): Repository
    {
        $this->items->put($key, $value);

        return $this;
    }
}
