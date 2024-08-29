<?php

namespace App\Configs;

use App\Core\Database\DatabaseManager;
use App\Core\Routes\Request;
use App\Core\Routes\Router;
use Dotenv\Dotenv;


$projectRootPath = dirname(__DIR__, 1);

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



/**
 * Mapeamento das rotas e migrations de cada modulo
 */
// Carregando as rotas dos módulos
$router = new Router();
$modules = ['Users', 'Customers']; // Lista de módulos, pode ser dinamicamente gerado
$modules_path = "/Modules";

foreach ($modules as $module) {
    $routesPath = sprintf('%s/%s/%s/Routes/routes.php', $projectRootPath, $modules_path, $module);
    if (file_exists($routesPath)) {
        $registerRoutes = require $routesPath;
        $registerRoutes($router);
    }
}

// Criando uma instância da requisição
$request = new Request();

// Manipulando a requisição atual
$router->handleRequest($request);
