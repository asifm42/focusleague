<?php

namespace Tests\Helpers;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\File;

// see https://adamwathan.me/2016/11/14/a-better-database-testing-workflow-in-laravel/
trait DatabaseSetup
{
    protected static $migrated = false;
    protected static $stubAndTestCreated = false;

    public function setupDatabase()
    {
        if ($this->isInMemory()) {
            $this->setupInMemoryDatabase();
        } else if ($this->isSqliteFlatFile()) {
            $this->setupSqliteFlatFileTestDatabase();
        } else {
            $this->setupTestDatabase();
        }
    }

    protected function isInMemory()
    {
        return config('database.connections')[config('database.default')]['database'] == ':memory:';
    }

    protected function isSqliteFlatFile()
    {
        return config('database.connections')[config('database.default')]['database'] == storage_path('testdb.sqlite');
    }

    protected function setupInMemoryDatabase()
    {
        $this->artisan('migrate');
        $this->app[Kernel::class]->setArtisan(null);
    }

    protected function setupSqliteFlatFileTestDatabase()
    {
        $this->createStubAndTestDbFileIfItDoesntExist();

        if (! static::$migrated) {
            $this->artisan('migrate:refresh', ["--database"=>"sqlite_testing_flat_file_setup"]);
            $this->app[Kernel::class]->setArtisan(null);
            static::$migrated = true;
        }

        exec('rm ' . storage_path('testdb.sqlite'));
        exec('cp ' . storage_path('stubdb.sqlite') .' ' . storage_path('testdb.sqlite'));
        $this->beginDatabaseTransaction();
    }

    protected function setupTestDatabase()
    {
        if (! static::$migrated) {
            $this->artisan('migrate:refresh');
            $this->app[Kernel::class]->setArtisan(null);
            static::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }

    public function beginDatabaseTransaction()
    {
        $database = $this->app->make('db');

        foreach ($this->connectionsToTransact() as $name) {
            $database->connection($name)->beginTransaction();
        }

        $this->beforeApplicationDestroyed(function () use ($database) {
            foreach ($this->connectionsToTransact() as $name) {
                $database->connection($name)->rollBack();
            }
        });
    }

    protected function connectionsToTransact()
    {
        return property_exists($this, 'connectionsToTransact')
                            ? $this->connectionsToTransact : [null];
    }

    public function createStubAndTestDbFileIfItDoesntExist()
    {
        if (! static::$stubAndTestCreated) {
            if (! File::Exists(config('database.connections.sqlite_testing_flat_file_setup.database'))) {
                exec('touch ' . config('database.connections.sqlite_testing_flat_file_setup.database'));
                exec('touch ' . config('database.connections.sqlite_testing_flat_file.database'));
            }
            static::$stubAndTestCreated = true;
        }
    }
}