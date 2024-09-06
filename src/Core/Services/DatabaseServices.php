<?php

namespace App\Core\Services;

use App\Core\Database\DatabaseManager;
use App\Core\Interfaces\DatabaseServicesInterface;
use App\Core\Interfaces\ModelInterface;


class DatabaseServices implements DatabaseServicesInterface
{

    function __construct(
        private readonly DatabaseManager $databaseManager = new DatabaseManager()
    ){
    }

    /**
     * Insert a new record in table
     *
     * @param ModelInterface $model
     * @return ModelInterface
     */
    public function insert(ModelInterface $model): ModelInterface
    {
        $table = $model->getTableName();

        // Split keys (columns) and values to SQL Query
        $data = $model->mapFieldsToArray();
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        // Prepare SQL Query to insert
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $statement = $this->databaseManager->getConnection()->prepare($sql);

        try {
            // Init transaction
            $this->databaseManager->getConnection()->beginTransaction();

            // Execute transaction
            if ($statement->execute($data)) {
                // Commit transaction
                $lastCreatedId = $this->databaseManager->getConnection()->lastInsertId();
                $this->databaseManager->getConnection()->commit();
                return $this->getLastRecord($model, $lastCreatedId);
            }

            // Roolback transaction if got error
            $this->databaseManager->getConnection()->rollBack();
            throw new \PDOException("Não foi possivel criar o registro no banco de dados");
        } catch (\PDOException $e) {
            // Roolback transaction if got error
            $this->databaseManager->getConnection()->rollBack();
            throw new \PDOException("Erro ao inserir no banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Update a record
     *
     * @param ModelInterface $model
     * @return bool
     */
    function update(ModelInterface $model): bool
    {
        $table = $model->getTableName();

        $data = $model->mapFieldsToArray();

        // Split keys (columns) and values to SQL Query
        $fields = implode(' = ?, ', array_keys($data)) . ' = ?';
        $values = array_values($data);
        $id = $data["id"];

        // Prepare SQL Query to insert
        $sql = "UPDATE $table SET $fields WHERE id = ?";

        $statement = $this->databaseManager->getConnection()->prepare($sql);

        try {
            // Init transaction
            $this->databaseManager->getConnection()->beginTransaction();

            // Execute transaction
            if ($statement->execute([...$values, $id])) {
                // Commit transaction
                $this->databaseManager->getConnection()->commit();
                return true;
            }

            // Roolback transaction if got error
            $this->databaseManager->getConnection()->rollBack();
            return false;
        } catch (\PDOException $e) {
            // Roolback transaction if got error
            $this->databaseManager->getConnection()->rollBack();
            throw new \PDOException("Erro ao atualizar no banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Delete a record
     *
     * @param ModelInterface $model
     * @return bool
     */
    public function delete(ModelInterface $model): bool
    {
        $table = $model->getTableName();
        $data = $model->mapFieldsToArray();
        $id = $data["id"];

        // Prepare SQL Query to delete record
        $sql = "DELETE FROM $table WHERE id = ?";

        $statement = $this->databaseManager->getConnection()->prepare($sql);

        try {
            // Init transaction
            $this->databaseManager->getConnection()->beginTransaction();

            if ($statement->execute([$id])) {
                // Commit transaction
                $this->databaseManager->getConnection()->commit();
                return true;
            }

            // Roolback transaction if got error
            $this->databaseManager->getConnection()->rollBack();
            return false;
        } catch (\PDOException $e) {
            // Roolback transaction if got error
            $this->databaseManager->getConnection()->rollBack();
            throw new \PDOException("Erro ao excluir do banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Get last created record
     *
     * @param ModelInterface $model
     * @param string $id
     * @return ModelInterface
     */
    private function getLastRecord(ModelInterface $model, string $id): ModelInterface
    {
        $table = $model->getTableName();
        $stmt = $this->databaseManager->getConnection()->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->execute([':id' => $id]);

        return $model::mapFieldFromArray($stmt->fetch(\PDO::FETCH_ASSOC));
    }
}