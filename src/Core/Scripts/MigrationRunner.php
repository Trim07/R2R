<?php


namespace App\Core\Scripts;

require_once  dirname(__DIR__, 3) . '/vendor/autoload.php';

use App\Core\Database\DatabaseManager;
use App\Providers\MigrationProvider;
use Dotenv\Dotenv;

/**
 * Run migrations on dump-autoload project
 */
class MigrationRunner
{

    /**
     * Run all migrations
     *
     * @return void
     */
    public function run(): void
    {
        $projectRootPath = dirname(__DIR__, 2);

        // load .env data
        $dotenv = Dotenv::createImmutable($projectRootPath);
        $dotenv->load();

        // initialize DatabaseManager
        $driver = $_ENV['DB_DRIVER'] ?? "mysql";
        DatabaseManager::initialize($driver);

        // Configuration of migrations
        $modules = ['Customers', 'Users'];
        $modules_path = "/Modules";


        $migrationManager = new MigrationProvider();
        foreach ($modules as $module) {
            $migrationManager->addMigrationDirectory(sprintf( "%s/%s/%s/Database/Migrations", $projectRootPath, $modules_path, $module)); // Adicionar o diretório para migracao.
        }

        // Execute all migrations
        $migrationManager->upMigration();
    }
}

(new MigrationRunner())->run();
