<?php

namespace App\Core\Services;

use App\Core\Database\DatabaseManager;
use App\Core\Interfaces\DatabaseServicesInterface;
use App\Core\Interfaces\ModelInterface;

/**
 * @implements DatabaseServicesInterface
 */

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

        // Separa as chaves (colunas) e os valores para a query SQL
        $data = $model->mapFieldsToArray();
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        // Preparar a query SQL de inserção
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $statement = $this->databaseManager->getConnection()->prepare($sql);

        try {
            // Iniciar a transação
            $this->databaseManager->getConnection()->beginTransaction();

            // Executar a query com os valores do modelo
            if ($statement->execute($data)) {
                // Commita a transação
                $lastCreatedId = $this->databaseManager->getConnection()->lastInsertId();
                $this->databaseManager->getConnection()->commit();
                return $this->getLastRecord($model, $lastCreatedId);
            }

            // Reverter a transação em caso de falha
            $this->databaseManager->getConnection()->rollBack();
            throw new \PDOException("Não foi possivel criar o registro no banco de dados");
        } catch (\PDOException $e) {
            // Reverter a transação em caso de exceção
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

        // Separar os campos e os valores para a query SQL
        $fields = implode(' = ?, ', array_keys($data)) . ' = ?';
        $values = array_values($data);
        $id = $data["id"];

        // Preparar a query SQL de atualização
        $sql = "UPDATE $table SET $fields WHERE id = ?";

        $statement = $this->databaseManager->getConnection()->prepare($sql);

        try {
            // Iniciar a transação
            $this->databaseManager->getConnection()->beginTransaction();

            // Executar a query com os valores do modelo
            if ($statement->execute([...$values, $id])) {
                // Commita a transação
                $this->databaseManager->getConnection()->commit();
                return true;
            }

            // Reverter a transação em caso de falha
            $this->databaseManager->getConnection()->rollBack();
            return false;
        } catch (\PDOException $e) {
            // Reverter a transação em caso de exceção
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

        // Preparar a query SQL de exclusão
        $sql = "DELETE FROM $table WHERE id = ?";

        $statement = $this->databaseManager->getConnection()->prepare($sql);

        try {
            // Iniciar a transação
            $this->databaseManager->getConnection()->beginTransaction();

            if ($statement->execute([$id])) {
                // Commita a transação
                $this->databaseManager->getConnection()->commit();
                return true;
            }

            // Reverter a transação em caso de falha
            $this->databaseManager->getConnection()->rollBack();
            return false;
        } catch (\PDOException $e) {
            // Reverter a transação em caso de exceção
            $this->databaseManager->getConnection()->rollBack();
            throw new \PDOException("Erro ao excluir do banco de dados: " . $e->getMessage());
        }
    }

    /**
     * @param ModelInterface $model
     * @param int $id
     * @return mixed
     */
    private function getLastRecord(ModelInterface $model, int $id): ModelInterface
    {
        $table = $model->getTableName();
        $stmt = $this->databaseManager->getConnection()->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->execute([':id' => $id]);

        return $model::mapFieldFromArray($stmt->fetch(\PDO::FETCH_ASSOC));
    }
}