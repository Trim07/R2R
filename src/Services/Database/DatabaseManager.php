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
     * Retorna a instância singleton do DatabaseManager.
     *
     * @return DatabaseManager
     */
    public static function getInstance(): DatabaseManager
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Retorna a conexão especifica para cada banco de dados
     *
     * @param string $driver
     * @return DatabaseConnection
     */
    private static function getConnector(string $driver): DatabaseConnection
    {
        return match ($driver) {
            'mysql' => new \Trimcorp\R2r\services\Database\MySQLConnection(),
            default => throw new RuntimeException('Driver de banco de dados não suportado ou inexistente: ' . $driver),
        };
    }
}