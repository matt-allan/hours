<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Config driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default configuration driver that should be used
    | by the application to store the user's application config.
    |
    | Supported Drivers: "file", "memory"
    |
    */
    'default' => env('CONFIG_DRIVER', 'file'),
];
