<?php

namespace Trimcorp\R2r\providers;

use InvalidArgumentException;
use Trimcorp\R2r\services\Database\DatabaseManager;

/**
 * Class that performs migrations to the database
 */

class MigrationProvider
{
    private array $directories = ['migrations']; // Diretórios padrão de migrations

    public function __construct(
        private DatabaseManager $databaseManager = new DatabaseManager
    ) {}

    /**
     * Adiciona um diretório para busca de migrations.
     *
     * @param string $directory O diretório a ser adicionado.
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
     * Executa a funções up() em migrations encontradas nos diretórios especificados.
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
                    echo "Método 'up' não encontrado na migration: {$className}\n";
                }
            }
        }
    }

    /**
     * Executa a função down() migrations encontradas nos diretórios especificados.
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
                    echo "Método 'up' não encontrado na migration: {$className}\n";
                }
            }
        }
    }

    /**
     * Obtém todos os arquivos de migration a partir do diretório especificado.
     *
     * @param string $directory O diretório para buscar arquivos de migration.
     * @return array Lista de caminhos de arquivos de migration.
     */
    private function getMigrationFiles(string $directory): array
    {
        return glob($directory . '/*.php');
    }
}
