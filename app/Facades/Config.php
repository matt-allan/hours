<?php

declare(strict_types=1);

namespace App\Facades;

use App\Config\Repository;
use App\Config\ConfigManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Repository driver(string $driver = null)
 *
 * @method static mixed get(string $key, mixed $default = null)
 * @method static Repository set(string $key, mixed $value)
 *
 * @see ConfigManager
 */
class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ConfigManager::class;
    }
}
