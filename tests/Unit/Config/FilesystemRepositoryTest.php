<?php

declare(strict_types=1);

namespace Tests\Unit\Config;

use Tests\TestCase;
use App\Config\FileRepository;
use Illuminate\Support\Facades\Storage;

class FilesystemRepositoryTest extends TestCase
{
    public function testPersistence()
    {
        Storage::fake('config');

        $config = new FileRepository();
        $config->set('foo', 'bar');
        $config->__destruct();

        Storage::disk('config')->assertExists('config.json');

        $config = new FileRepository();
        $this->assertEquals('bar', $config->get('foo'));
    }
}
