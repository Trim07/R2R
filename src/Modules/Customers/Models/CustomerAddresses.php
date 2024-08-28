<?php

namespace App\Modules\Customers\Models;

use App\Core\Interfaces\ModelInterface;


/**
 *  Customers Addresses Model Class
 *  Contains whole fields from respective table
 *
 * @implements ModelInterface
 */
class CustomerAddresses implements ModelInterface
{

    private readonly string $table;

    function __construct(
        public ?int $id = null,
        public ?int $customer_id = null,
        public ?string $name = null,
        public ?string $street = null,
        public ?string $number = null,
        public ?string $neighborhood = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $country = null,
        public ?string $zipcode = null,
        public ?string $complement = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {
        $this->table = 'customer_addresses';
    }

    /**
     * @param array $array
     * @return ModelInterface
     */
    static function mapFieldFromArray(array $array): ModelInterface
    {
        return new self(
            name: $array['name'] ?? null,
            street: $array['street'] ?? null,
            number: $array['number'] ?? null,
            neighborhood: $array['neighborhood'] ?? null,
            city: $array['city'] ?? null,
            state: $array['state'] ?? null,
            country: $array['country'] ?? null,
            zipcode: $array['zipcode'] ?? null,
            complement: $array['complement'] ?? null,
            created_at: $array['created_at'] ?? null,
            updated_at: $array['updated_at'] ?? null,
        );
    }

    /**
     * @return array
     */
    function mapFieldsToArray(): array
    {
        return [
            "name" =>  $this->name ?? null,
            "street" =>  $this->street ?? null,
            "number" =>  $this->number ?? null,
            "neighborhood" =>  $this->neighborhood ?? null,
            "city" =>  $this->city ?? null,
            "state" =>  $this->state ?? null,
            "country" =>  $this->country ?? null,
            "zipcode" =>  $this->zipcode ?? null,
            "complement" =>  $this->complement ?? null,
            "created_at" =>  $this->created_at ?? null,
            "updated_at" =>  $this->updated_at ?? null,
        ];
    }

    /**
     * @return string
     */
    function getTableName(): string
    {
        return $this->table;
    }
}
