<?php

namespace App\Core\AbstractClasses;

use App\Core\Database\DatabaseManager;
use PDO;


/**
 * Abstract class to make sql consults
 */
abstract class BaseRepository{

    protected string $table;
    protected array $conditions = [];
    protected array $bindings = [];
    protected string $selectColumns = '*';

    function __construct(
        protected DatabaseManager $databaseManager = new DatabaseManager()
    ){}

    /**
     * Method to execute SQL query.
     *
     * @param string $query SQL query string.
     * @return array results
     */
    protected function exec(string $query): array
    {
        try {
            $stmt = $this->databaseManager->getConnection()->prepare($query);
            $stmt->execute($this->bindings);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    /**
     * Set table to SQL query
     *
     * @param string $table
     * @return BaseRepository
     */
    protected function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

     /**
     * Set the columns to select
     *
     * @param array $columns Columns to select
     * @return $this
     */
    public function select(array $columns = ['*']): self
    {
        $this->selectColumns = implode(', ', $columns);
        return $this;
    }

    /**
     * Build and execute the SQL query with the current conditions.
     *
     * @return array Result set
     */
    public function get(): array
    {
        $query = $this->buildQuery();
        return $this->exec($query);
    }

    /**
     * Build and execute the SQL query with the current conditions.
     *
     * @return array|null Result set
     */
    public function first(): ?array
    {
        $query = $this->get();

        if(!empty($query)){
            return $query[0];
        }
        return null;
    }

    /**
     * Build the SQL query with the current conditions.
     *
     * @return string
     */
    protected function buildQuery(): string
    {
        $query = "SELECT $this->selectColumns FROM $this->table";

        if (!empty($this->conditions)) {
            $conditionsString = implode(' ', $this->conditions);
            $conditionsString = preg_replace('/^(AND|OR) /', '', $conditionsString, 1);
            $query .= " WHERE $conditionsString";
        }

        return $query;
    }

    /**
     * Add a where condition to SQL query.
     *
     * @param string $column Column name
     * @param string $operator Comparison operator (=, <, >, <=, >=, != and other conditions supported by the database)
     * @param mixed $value Value to compare
     * @return $this
     */
    public function where(string $column, string $operator, mixed $value): self
    {
        return $this->addCondition('AND', $column, $operator, $value);
    }

    /**
     * Add an orWhere condition to SQL query.
     *
     * @param string $column Column name
     * @param string $operator Comparison operator (=, <, >, <=, >=, !=, etc.)
     * @param mixed $value Value to compare
     * @return $this
     */
    public function orWhere(string $column, string $operator, mixed $value): self
    {
        return $this->addCondition('OR', $column, $operator, $value);
    }

    /**
     * Add a condition to SQL query.
     *
     * @param string $type Condition type (AND, OR)
     * @param string $column Column name
     * @param string $operator Comparison operator (=, <, >, <=, >=, !=, etc.)
     * @param mixed $value Value to compare
     * @return $this
     */
    protected function addCondition(string $type, string $column, string $operator, mixed $value): self
    {
        $placeholder = str_replace('.', '_', $column) . count($this->bindings);
        $this->conditions[] = "$type $column $operator :$placeholder";
        $this->bindings[$placeholder] = $value;

        return $this;
    }
}