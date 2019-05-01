<?php

declare(strict_types=1);

namespace App\Bootstrap;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Contracts\Filesystem\Filesystem;

class InitializeDatabase
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Migrator
     */
    private $migrator;

    /**
     * @var string
     */
    private $databasePath;

    public function __construct(Filesystem $filesystem, Migrator $migrator, string $databasePath)
    {
        $this->filesystem = $filesystem;
        $this->migrator = $migrator;
        $this->databasePath = $databasePath;
    }

    public function bootstrap(): void
    {
        if (! $this->filesystem->exists($this->databasePath)) {
            $this->filesystem->put($this->databasePath, '');
        }

        if (! $this->migrator->repositoryExists()) {
            $this->migrator->getRepository()->createRepository();
        }

        $this->migrator->run(database_path('migrations'));
    }
}
