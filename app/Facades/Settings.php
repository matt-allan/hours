<?php

declare(strict_types=1);

namespace App\Facades;

use App\Settings\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static Repository set(string $key, mixed $value)
 * @method static Collection all()
 */
class Settings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Repository::class;
    }
}
