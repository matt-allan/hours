<?php

declare(strict_types=1);

namespace App\Bootstrap;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Migrations\Migrator;

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
            File::put($databasePath, '');
        }

        if (! $this->migrator->repositoryExists()) {
            $this->migrator->getRepository()->createRepository();
        }

        $this->migrator->run(database_path('migrations'));
    }
}
