<?php

namespace App\Modules\Customers\Models;

use App\Core\Interfaces\ModelInterface;


/**
 *  Customer Addresses Model Class
 *  Contains whole fields from respective table
 */
final class CustomerAddresses implements ModelInterface
{

    private readonly string $table;

    function __construct(
        public readonly ?int $id = null,
        public readonly ?int $customer_id = null,
        public readonly ?string $name = null,
        public readonly ?string $street = null,
        public readonly ?string $number = null,
        public readonly ?string $neighborhood = null,
        public readonly ?string $city = null,
        public readonly ?string $state = null,
        public readonly ?string $country = null,
        public readonly ?string $zipcode = null,
        public readonly ?string $complement = null,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
    ) {
        $this->table = 'customer_addresses';
    }

    /**
     * @param array $array
     * @return CustomerAddresses
     */
    static function mapFieldFromArray(array $array): self
    {
        return new self(
            id: $array['id'] ?? null,
            customer_id: $array['customer_id'] ?? null,
            name: $array['name'] ?? null,
            street: $array['street'] ?? null,
            number: $array['number'] ?? null,
            neighborhood: $array['neighborhood'] ?? null,
            city: $array['city'] ?? null,
            state: $array['state'] ?? null,
            country: $array['country'] ?? null,
            zipcode: $array['zipcode'] ?? null,
            complement: $array['complement'] ?? null,
        );
    }

    /**
     * @return array
     */
    function mapFieldsToArray(): array
    {
        return [
            "id" => $this->id ?? null,
            "customer_id" => $this->customer_id ?? null,
            "name" =>  $this->name ?? null,
            "street" =>  $this->street ?? null,
            "number" =>  $this->number ?? null,
            "neighborhood" =>  $this->neighborhood ?? null,
            "city" =>  $this->city ?? null,
            "state" =>  $this->state ?? null,
            "country" =>  $this->country ?? null,
            "zipcode" =>  $this->zipcode ?? null,
            "complement" =>  $this->complement ?? null,
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
