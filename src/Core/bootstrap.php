<?php

namespace App\Configs;

use App\Core\Database\DatabaseManager;
use App\Core\Routes\Request;
use App\Core\Routes\Router;
use Dotenv\Dotenv;


$projectRootPath = dirname(__DIR__, 1);

/**
 * Load environment variables from the ./.env file, can be used through the global variable $[_ENV]
 */
$dotenv = Dotenv::createImmutable(__DIR__."\..\\");
$dotenv->load();



/**
 * Starts a Singleton connection to the database
 * Every time you start the application, a Singleton instance of the database connection will be created.
 */
$driver = $_ENV['DB_DRIVER'] ?? "mysql";
DatabaseManager::initialize($driver);



/**
 * Mapping the routes
 */
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

// Creating a request instance
$request = new Request();

// Handling the current request
$router->handleRequest($request);
