<?php

declare(strict_types=1);

namespace Tests\Unit\Config;

use Tests\TestCase;
use App\Config\FilesystemRepository;
use Illuminate\Support\Facades\Storage;

class FilesystemRepositoryTest extends TestCase
{
    public function testPersistence()
    {
        Storage::fake('config');

        $config = new FilesystemRepository();
        $config->set('foo', 'bar');
        $config->__destruct();

        Storage::disk('config')->assertExists('config.json');

        $config = new FilesystemRepository();
        $this->assertEquals('bar', $config->get('foo'));
    }
}
