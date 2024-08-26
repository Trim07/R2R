<?php

namespace Trimcorp\R2r\services\Database;

use PDO;
use RuntimeException;

/**
 * Manager database connection, it uses Singleton Pattern
 */
class DatabaseManager
{
    private static ?DatabaseConnection $connection = null;


    /**
     * Initialize the database connection.
     *
     * @param DatabaseConnection $connection database connection instance.
     */
    public static function initialize(DatabaseConnection $connection): void
    {
        if (self::$connection === null) {
            self::$connection = $connection;
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
}