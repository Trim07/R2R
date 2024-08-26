<?php

namespace Trimcorp\R2r\configs;

use Dotenv\Dotenv;
use RuntimeException;
use Trimcorp\R2r\services\Database\DatabaseManager;


// Carregar as variáveis de ambiente do arquivo ./.env, poderá ser utilizado através da variavel global $[_ENV]
$dotenv = Dotenv::createImmutable(__DIR__."\..\\");
$dotenv->load();


// Sempre que iniciar a aplicação, uma instancia Singleton de conexão com o banco de dados será criada
$driver = $_ENV['DB_DRIVER'];
$connection = match ($driver) {
    'mysql' => new \Trimcorp\R2r\services\Database\MySQLConnection(),
    default => throw new RuntimeException('Driver de banco de dados não suportado ou inexistente: ' . $driver),
};

// inicializa a conexão com o banco de dados.
DatabaseManager::initialize($connection);