<?php

namespace App\Services\Database;

use PDO;
use PDOException;
use RuntimeException;


/**
 * MySQLConnection class to make connection to database
 * @extends DatabaseConnection
 */
class MySQLConnection extends DatabaseConnection
{
    /**
     * Create a connection with MySQL database
     * @return void
     */
    protected function connect(): void
    {
        $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4";
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new RuntimeException('Falha na conexão com o banco de dados: ' . $e->getMessage());
        }
    }
}
