<?php

namespace App\Core\Database;

use PDO;
use RuntimeException;

/**
 * Manager database connection, it uses Singleton Pattern
 */
class DatabaseManager
{
    private static ?DatabaseConnection $connection = null;
    private static ?DatabaseManager $instance = null;


    /**
     * Initialize the database connection.
     *
     * @param string $connector
     */
    public static function initialize(string $connector): void
    {
        if (self::$connection === null) {
            self::$connection = self::getConnector($connector);
        }
    }

    /**
     * Get database connection
     *
     * @return PDO connection instance
     * @throws RuntimeException If the connection has been not established.
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            throw new RuntimeException('Conexão com o banco de dados não inicializada.');
        }
        return self::$connection->getConnection();
    }

    /**
     * Return Connection for each database connection type
     *
     * @param string $driver
     * @return DatabaseConnection
     */
    private static function getConnector(string $driver): DatabaseConnection
    {
        return match ($driver) {
            'mysql' => new \App\Core\Database\MySQLConnection(),
            default => throw new RuntimeException('Driver de banco de dados não suportado ou inexistente: ' . $driver),
        };
    }
}