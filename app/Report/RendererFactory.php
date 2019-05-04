<?php

declare(strict_types=1);

namespace App\Report;

interface RendererFactory
{
    public function make(string $format): Renderer;
}
