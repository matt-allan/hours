<?php

declare(strict_types=1);

namespace App\Report;

use Psr\Container\ContainerInterface;

class RendererManager implements RendererFactory
{
    /**
     * @var ContainerInterface
     */
    private $app;

    /**
     * @var \Closure[]
     */
    private $customCreators = [];

    public function __construct(ContainerInterface $app)
    {
        $this->app = $app;
    }

    public function make(string $format): Renderer
    {
        if (array_key_exists($format, $this->customCreators)) {
            return $this->customCreators[$format]($this->app);
        }

        $driverMethod = 'create'.ucfirst($format).'Driver';

        if (!method_exists($this, $driverMethod)) {
            throw new \InvalidArgumentException('Unknown format ' . $format);
        }

        return $this->{$driverMethod}();
    }

    public function extend(string $format, \Closure $callback): self
    {
        $this->customCreators[$format] = $callback->bindTo($this, $this);

        return $this;
    }

    private function createCsvDriver(): CsvRenderer
    {
        return $this->app->get(CsvRenderer::class);
    }

    private function createJsonDriver(): JsonRenderer
    {
        return $this->app->get(JsonRenderer::class);
    }

    private function createTextDriver()
    {
        return $this->app->get(TextRenderer::class);
    }
}
