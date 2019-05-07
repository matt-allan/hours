<?php

declare(strict_types=1);

namespace App\Report;

interface RendererFactory
{
    /**
     * @param string|null $driver
     *
     * @return Renderer
     */
    public function driver($driver = null);
}
