<?php

declare(strict_types=1);

namespace App\Settings;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DatabaseRepository implements Repository
{
    public function get(string $key, $default = null)
    {
        $value = DB::table('settings')
            ->where('name', $key)
            ->first('value');

        return $value !== null ? $value->value : $default;
    }

    public function set(string $key, $value): Repository
    {
        DB::table('settings')
            ->updateOrInsert(['name' => $key], ['value' => $value]);

        return $this;
    }

    public function all(): Collection
    {
        return DB::table('settings')
            ->get()
            ->map(function ($setting) {
                return (array) $setting;
            });
    }
}
