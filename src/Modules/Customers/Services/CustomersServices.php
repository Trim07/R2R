<?php

namespace App\Modules\Customers\Services;

use App\Core\Database\DatabaseManager;
use App\Core\Interfaces\ModelInterface;
use App\Core\Interfaces\ServicesInterface;
use App\Core\Services\DatabaseServices;
use App\Modules\Customers\Models\Customers;

/**
 * Can be used to access external services or manipulate the database, for example
 *
 * @implements ServicesInterface
 */
class CustomersServices implements ServicesInterface
{

    function __construct(
        private readonly DatabaseServices $databaseServices = new DatabaseServices()
    ){}

    /**
     * Create a new record
     *
     * @param ModelInterface $data
     * @return void
     */
    function create(ModelInterface $data): void
    {
        $this->databaseServices->insert($data);
    }

    /**
     * Update a record
     *
     * @param ModelInterface $data
     * @return void
     */
    function update(ModelInterface $data): void
    {
        $this->databaseServices->update($data);
    }

    /**
     * Delete a record
     *
     * @param ModelInterface $data
     * @return void
     */
    function delete(ModelInterface $data): void
    {
        $this->databaseServices->delete($data);
    }

    /**
     * Map fields to Customers model
     *
     * @param array $data
     * @return Customers
     */
    public function mapFields(array $data): Customers
    {
        return Customers::mapFieldFromArray($data);
    }
}