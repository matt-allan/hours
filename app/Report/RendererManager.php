<?php

declare(strict_types=1);

namespace App\Report;

use Illuminate\Support\Manager;

class RendererManager extends Manager implements RendererFactory
{
    public function getDefaultDriver(): string
    {
        return 'text';
    }

    public function createCsvDriver(): CsvRenderer
    {
        return new CsvRenderer();
    }

    public function createJsonDriver(): JsonRenderer
    {
        return new JsonRenderer();
    }

    public function createTextDriver(): TextRenderer
    {
        return new TextRenderer();
    }
}
