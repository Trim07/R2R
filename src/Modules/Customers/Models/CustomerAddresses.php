<?php

namespace App\Modules\Customers\Models;

class CustomerAddresses
{

    function __construct(
        public ?int $id = null,
        public ?int $customer_id = null,
        public string $name,
        public string $street,
        public string $number,
        public string $neighborhood,
        public string $city,
        public string $state,
        public string $country,
        public string $zipcode,
        public ?string $complement = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}
}
