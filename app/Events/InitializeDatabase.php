<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\File;

/**
 * Creates the database if it doesn't exist and migrates it when the app starts.
 */
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
        $databasePath = (string) config('database.connections.sqlite.database');

        if ($databasePath !== ':memory:' && ! File::exists($databasePath)) {
            File::ensureDirectoryExists(dirname($databasePath));
            File::put($databasePath, '');
        }

        if (! $this->migrator->repositoryExists()) {
            $this->migrator->getRepository()->createRepository();
        }

        $this->migrator->run(database_path('migrations'));
    }
}
