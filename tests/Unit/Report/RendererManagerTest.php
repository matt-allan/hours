<?php

declare(strict_types=1);

namespace Tests\Unit\Report;

use App\Report;
use App\Report\CsvRenderer;
use App\Report\JsonRenderer;
use App\Report\Renderer;
use App\Report\RendererManager;
use App\Report\TextRenderer;
use Symfony\Component\Console\Output\OutputInterface;
use Tests\TestCase;

class RendererManagerTest extends TestCase
{
    public function testMake()
    {
        $manager = new RendererManager($this->app);

        $this->assertInstanceOf(CsvRenderer::class, $manager->driver('csv'));
        $this->assertInstanceOf(JsonRenderer::class, $manager->driver('json'));
        $this->assertInstanceOf(TextRenderer::class, $manager->driver('text'));
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

        $this->assertSame($nullRenderer, $manager->driver('null'));
    }
}
