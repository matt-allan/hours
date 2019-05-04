<?php

declare(strict_types=1);

namespace App\Config;

interface Editable
{
    public function edit(): void;
}
