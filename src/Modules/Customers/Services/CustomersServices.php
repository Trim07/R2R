<?php

namespace App\Modules\Customers\Services;


use App\Core\Exceptions\CustomerException;
use App\Core\Interfaces\ServicesInterface;
use App\Core\Services\DatabaseServices;
use App\Modules\Customers\Models\Customers;
use App\Modules\Customers\Repositories\CustomersRepository;
use App\Modules\Users\Services\AuthService;

/**
 * Can be used to access external services or manipulate the database, for example
 *
 * @implements ServicesInterface
 */
class CustomersServices implements ServicesInterface
{

    function __construct(
        private readonly DatabaseServices $databaseServices = new DatabaseServices(),
        private readonly CustomersRepository $customersRepository = new CustomersRepository(),
    ){}

    /**
     * Create a new record
     *
     * @param array $data
     * @return void
     * @throws CustomerException
     */
    function create(array $data): void
    {
        $data["customer"]["user_id"] = AuthService::getSession()["id"]; // get current logged user.;
        $customerModel = $this->mapFields($data["customer"]);
        if($this->customersRepository->checkIfCustomerExists($customerModel) === false){
            $customer = $this->databaseServices->insert($customerModel); // insert customers into table
            if(!empty($data["addresses"])){
                (new CustomerAddressesServices)->create($data["addresses"], $customer->id); // update addresses
            }
            return;
        }
        throw new CustomerException("Já existe um cliente cadastrado com essas informações.", [], 409);

    }

    /**
     * Update a record
     *
     * @param array $data
     * @return void
     */
    function update(array $data): void
    {
        $data["customer"]["user_id"] = AuthService::getSession()["id"]; // get current logged user.;
        $customerModel = $this->mapFields($data["customer"]);
        $this->databaseServices->update($customerModel); // update customer

        if(!empty($data["addresses"])){
            (new CustomerAddressesServices)->update($data["addresses"], $customerModel->id); // update addresses
        }
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