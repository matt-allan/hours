<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class CarbonInterval implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  string  $value
     * @param  array  $attributes
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new \Carbon\CarbonInterval($value);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  \Carbon\CarbonInterval $value
     * @param  array  $attributes
     *
     * @return array|string
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (! $value instanceof \Carbon\CarbonInterval) {
            throw new \InvalidArgumentException(sprintf(
                'The given value must be a %s instance.',
                \Carbon\CarbonInterval::class
            ));
        }

        return $value->spec();
    }
}
