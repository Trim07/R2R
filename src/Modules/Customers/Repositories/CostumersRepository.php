<?php

namespace App\Modules\Customers\Repositories;

use App\Core\AbstractClasses\BaseRepository;
use App\Modules\Customers\Models\Customers;

/**
 * Read data from costumers table
 */
class CostumersRepository extends BaseRepository
{
    private readonly string $table;

    function __construct(
        private readonly Customers $customers = new Customers
    ){
        $this->table = $this->customers->table;
        parent::__construct();
    }

    /**
     * find record by id
     *
     * @param int $id Id do documento
     * @param array $columns Colunas a serem selecionadas
     *
     * @return array
     */
    public function findById(int $id, array $columns = ['*']): array
    {
        $columnsString = implode(', ', $columns);
        $query = "SELECT $columnsString FROM $this->table WHERE id = ?";
        return $this->exec($query, [$id]);
    }

    /**
     * select records and do conditionals
     *
     * @param array $columns Colunas a serem selecionadas
     * @param array $conditions Condições / Where para filtragem
     *
     * @return array Retorno dos dados
     */
    public function select(array $columns = ['*'], array $conditions = []): array
    {
        $columnsString = implode(', ', $columns);
        $query = "SELECT $columnsString FROM $this->table";

        if (!empty($conditions)) {
            $conditionsString = implode(' AND ', array_map(fn($col) => "$col = :$col", array_keys($conditions)));
            $query .= " WHERE $conditionsString";
        }

        return $this->exec($query, $conditions);
    }
}