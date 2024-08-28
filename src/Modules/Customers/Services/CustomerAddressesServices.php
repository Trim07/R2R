<?php

namespace App\Modules\Customers\Services;

use App\Core\Interfaces\ItemsServicesInterface;
use App\Core\Interfaces\ServicesInterface;
use App\Core\Services\DatabaseServices;
use App\Modules\Customers\Models\CustomerAddresses;
use App\Modules\Customers\Repositories\CustomerAddressesRepository;

/**
 * Can be used to access external services or manipulate the database, for example
 *
 * @implements ServicesInterface
 */
class CustomerAddressesServices implements ItemsServicesInterface
{

    function __construct(
        private readonly DatabaseServices $databaseServices = new DatabaseServices()
    ){}

    /**
     * Create a new record
     *
     * @param array $data
     * @param int $father_id
     * @return void
     */
    function create(array $data, int $father_id): void
    {
        foreach ($data as $address) {
            $addressModel = $this->mapFields($address);
            $addressModel->setCustomerId($father_id);
            $this->databaseServices->insert($addressModel);
        }
    }

    /**
     * Update a record
     *
     * @param array $data
     * @param int $father_id
     * @return void
     */
    function update(array $data, int $father_id): void
    {
        $this->deleteAll($father_id);
        $this->create($data, $father_id);
    }

    /**
     * Delete a record
     *
     * @param array $data
     * @return void
     */
    function delete(array $data): void
    {
        /**
         * TODO: Can be added in an other moment
         */
    }

    /**
     * @param int $father_id
     * @return bool
     */
    function deleteAll(int $father_id): bool
    {
        $addresses = (new CustomerAddressesRepository)->select(["*"], ['customer_id' => $father_id]);

        foreach ($addresses as $address) {
            $modelMappedFields = $this->mapFields($address);
            $this->databaseServices->delete($modelMappedFields);
        }
        return true;
    }

    /**
     * Map fields to Customers model
     *
     * @param array $data
     * @return CustomerAddresses
     */
    private function mapFields(array $data): CustomerAddresses
    {
        return CustomerAddresses::mapFieldFromArray($data);
    }
}