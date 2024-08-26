<?php

namespace Trimcorp\R2r\services\Database;

use PDO;

/**
 * Abstract class to make Database Connections.
 */
abstract class DatabaseConnection
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->connect();
    }

    /**
     * Abstract method that need be implemented
     */
    abstract protected function connect(): void;

    /**
     * Returns a PDO Instance.
     *
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}