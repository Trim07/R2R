<?php

namespace App\Core\Migrations;

use App\Core\Database\DatabaseManager;
use InvalidArgumentException;


/**
 * Class that performs migrations to the database
 */
class MigrationProvider
{
    private array $directories = ['migrations']; // Default migration directories

    public function __construct(
        private readonly DatabaseManager $databaseManager = new DatabaseManager
    ) {}

    /**
     * Add array migrations directory.
     *
     * @param string $directory Directory to search migrations.
     */
    public function addMigrationDirectory(string $directory): void
    {
        if (is_dir($directory)) {
            $this->directories[] = $directory;
        } else {
            throw new InvalidArgumentException("O diretório {$directory} não existe.");
        }
    }

    /**
     * Execute up() function on migrations
     * @return void
     */
    public function upMigration(): void
    {
        foreach ($this->directories as $directory) {
            $files = $this->getMigrationFiles($directory);

            foreach ($files as $file) {
                $migration = require_once $file;

                if (method_exists($migration, 'up')) {
                    echo "Executando migration: {$file}\n";
                    $this->databaseManager->getConnection()->exec($migration->up());
                } else {
                    echo "Método 'up' não encontrado na migration\n";
                }
            }
        }
    }

    /**
     * Execute down() function on migrations
     * @return void
     */
    public function downMigration(): void
    {
        foreach ($this->directories as $directory) {
            $files = $this->getMigrationFiles($directory);

            foreach ($files as $file) {
                $migration = require_once $file;

                if (method_exists($migration, 'up')) {
                    echo "Executando migration: {$file}\n";
                    $this->databaseManager->getConnection()->exec($migration->up());
                } else {
                    echo "Método 'up' não encontrado na migration\n";
                }
            }
        }
    }

    /**
     * Get all migration files from directory
     *
     * @param string $directory
     * @return array
     */
    private function getMigrationFiles(string $directory): array
    {
        return glob($directory . '/*.php');
    }
}
