<?php

namespace App\Core\AbstractClasses;

use \PDO;
use App\Services\Database\DatabaseManager;


/**
 * Abstract class to make sql consults
 */
abstract class BaseRepository{

    function __construct(
        protected DatabaseManager $databaseManager = new DatabaseManager()
    ){}

    /**
     * Método para executar consulta SQL.
     *
     * @param string $query SQL a ser executado.
     * @param array $params Parâmetros para a consulta.
     * @return array Resultados da consulta
     */
    protected function exec(string $query, array $params = []): array
    {
        try {
            $stmt = $this->databaseManager->getConnection()->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Método abstrato para selecionar registros.
     *
     * @param array $columns Colunas a serem selecionadas.
     * @param array $conditions Condições / Wheres para filtragem.
     * @return array Resultados da consulta.
     */
    abstract public function select(array $columns = ['*'], array $conditions = []): array;


}