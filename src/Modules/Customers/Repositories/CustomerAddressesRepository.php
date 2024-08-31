<?php

namespace App\Modules\Customers\Repositories;

use App\Core\AbstractClasses\BaseRepository;
use App\Modules\Customers\Models\CustomerAddresses;

/**
 * Read data from costumers table
 *
 * @extends BaseRepository
 */
class CustomerAddressesRepository extends BaseRepository
{

    function __construct(
        private readonly CustomerAddresses $customersAddresses = new CustomerAddresses
    ){
        parent::__construct();
        $this->table = $this->customersAddresses->getTableName();
    }

    /**
     * find record by customer_id
     *
     * @param int $customerId
     * @return array
     */
    public function findByCustomerId(int $customerId): array
    {
        return $this->select()->where("customer_id", "=", $customerId)->get();
    }
}