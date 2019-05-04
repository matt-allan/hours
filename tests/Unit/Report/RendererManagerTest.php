<?php

declare(strict_types=1);

namespace Tests\Unit\Report;

use App\Report;
use Tests\TestCase;
use App\Report\Renderer;
use App\Report\CsvRenderer;
use App\Report\JsonRenderer;
use App\Report\TextRenderer;
use App\Report\RendererManager;
use Symfony\Component\Console\Output\OutputInterface;

class RendererManagerTest extends TestCase
{
    public function testMake()
    {
        $manager = new RendererManager($this->app);

        $this->assertInstanceOf(CsvRenderer::class, $manager->make('csv'));
        $this->assertInstanceOf(JsonRenderer::class, $manager->make('json'));
        $this->assertInstanceOf(TextRenderer::class, $manager->make('text'));
    }

    public function testExtend()
    {
        $manager = new RendererManager($this->app);

        $nullRenderer = new class() implements Renderer {
            public function render(OutputInterface $output, Report $report)
            {
            }
        };

        $manager->extend('null', function () use ($nullRenderer) {
            return $nullRenderer;
        });

        $this->assertSame($nullRenderer, $manager->make('null'));
    }
}
