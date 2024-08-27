<?php

namespace Trimcorp\R2r\configs;

use Dotenv\Dotenv;
use Trimcorp\R2r\Providers\MigrationProvider;
use Trimcorp\R2r\services\Database\DatabaseManager;


/**
 * Carregar as variáveis de ambiente do arquivo ./.env, poderá ser utilizado através da variavel global $[_ENV]
 */
$dotenv = Dotenv::createImmutable(__DIR__."\..\\");
$dotenv->load();

/**
 * Inicia uma conexão Singleton com o banco de dados
 * Sempre que iniciar a aplicação, uma instancia Singleton de conexão com o banco de dados será criada
 */
$driver = $_ENV['DB_DRIVER'] ?? "mysql";
DatabaseManager::initialize($driver);


///**
// * Executa migrações caso tenha alguma pendente
// */
//$migrationManager = new MigrationProvider();
//
//// Adicionar o diretório para migracao.
//$migrationManager->addMigrationDirectory(__DIR__ . "\..\\App\Modules\Customers\Database\Migrations");
//
//// Executar todas as migrations que foram adicionadas através da função addMigrationDirectory()
//$migrationManager->upMigration();