<?php

namespace App\Modules\Customers\Services;


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
        private readonly DatabaseServices $databaseServices = new DatabaseServices(),
    ){}

    /**
     * Create a new record
     *
     * @param array $data
     * @return void
     */
    function create(array $data): void
    {
        $customerModel = $this->mapFields($data["customer"]);
        $customer = $this->databaseServices->insert($customerModel); // insert customers into table

        (new CustomerAddressesServices)->create($data["addresses"], $customer->id); // insert addresses into table
    }

    /**
     * Update a record
     *
     * @param array $data
     * @return void
     */
    function update(array $data): void
    {
        $customerModel = $this->mapFields($data["customer"]);
        $this->databaseServices->update($customerModel); // update customer
        (new CustomerAddressesServices)->update($data["addresses"], $customerModel->id); // update addresses
    }

    /**
     * Delete a record
     *
     * @param array $data
     * @return void
     */
    function delete(array $data): void
    {
        $modelMappedFields = $this->mapFields($data);
        $isDeletedAllAddresses = (new CustomerAddressesServices)->deleteAll($modelMappedFields->id);
        if($isDeletedAllAddresses){
            $this->databaseServices->delete($modelMappedFields);
        }
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