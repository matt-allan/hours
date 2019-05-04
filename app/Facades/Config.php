<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Config\Repository as ConfigRepository;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static ConfigRepository set(string $key, mixed $value)
 */
class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ConfigRepository::class;
    }
}
