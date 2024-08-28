<?php

namespace App\Modules\Customers\Repositories;

use App\Core\AbstractClasses\BaseRepository;
use App\Modules\Customers\Models\Customers;

/**
 * Read data from costumers table
 *
 * @extends BaseRepository
 */
class CustomersRepository extends BaseRepository
{

    function __construct(
        private readonly Customers $customers = new Customers
    ){
        parent::__construct();
    }

    /**
     * find record by id
     *
     * @param int $id ID of record
     * @return array
     * @throws \Exception
     */
    public function findById(int $id): array
    {
        $customer = $this->findOrFail($id);
        $customer_addresses = (new CustomerAddressesRepository)->findByCustomerId($id);

        return [
            "customer" => $customer,
            "addresses" => $customer_addresses,
        ];
    }

    /**
     *
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function findOrFail(int $id): array
    {
        $customer = $this->table($this->customers->getTableName())->select()->where("id", "=", $id)->get();
        if(empty($customer)){
            http_response_code(204);
            throw new \Exception("Cliente não encontrado");
        }
        return $customer[0];
    }
}