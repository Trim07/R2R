<?php

namespace App\Core\Scripts;

/**
 * Start application
 */
class RunServer
{

    /**
     * @return void
     */
    static function run(): void
    {
        $directory = dirname(__DIR__, 2) . "/public";
        chdir($directory);
        exec('php -S localhost:8000');
    }
}

RunServer::run();
