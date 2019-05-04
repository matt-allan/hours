<?php

declare(strict_types=1);

namespace App\Bootstrap;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class InitializeDatabase
{
    /**
     * @var Migrator
     */
    private $migrator;

    public function __construct(Migrator $migrator)
    {
        $this->migrator = $migrator;
    }

    public function handle(): void
    {
        $databasePath = basename(config('database.connections.sqlite.database'));

        if (! Storage::disk('data')->exists($databasePath)) {
            Storage::disk('data')->put($databasePath, '');
        }

        if (! $this->migrator->repositoryExists()) {
            $this->migrator->getRepository()->createRepository();
        }

        $this->migrator->run(database_path('migrations'));
    }
}
