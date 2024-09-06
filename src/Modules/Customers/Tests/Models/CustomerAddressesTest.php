<?php

namespace App\Modules\Customers\Tests\Models;

use App\Modules\Customers\Models\CustomerAddresses;
use PHPUnit\Framework\TestCase;


final class CustomerAddressesTest extends TestCase
{

    public function testCanBeCreatedFromValidArray(): void
    {
        $data = [
            "id" => 1,
            "customer_id" => 1,
            "name" => "Casa",
            "street" => "2° tv",
            "number" => "3A",
            "neighborhood" => "SCV",
            "city" => "Salvador",
            "state" => "BA",
            "country" => "BR",
            "zipcode" => "41500000",
            "complement" => "Casa de lado"
        ];

        $mapped_customer_address = CustomerAddresses::mapFieldFromArray($data);

        $this->assertInstanceOf(CustomerAddresses::class, $mapped_customer_address);
    }

    public function testCanmapFieldsToArray(): void
    {
        $customer_address = new CustomerAddresses(
            id: 1,
            customer_id: 1,
            name: "Casa",
            street: "2° tv",
            number: "3A",
            neighborhood: "SCV",
            city: "Salvador",
            state: "BA",
            country: "BR",
            zipcode: "41500000",
            complement: "Casa de lado"
        );

        $mapped_customer_address = $customer_address->mapFieldsToArray();

        $this->assertIsArray($mapped_customer_address);
        $this->assertEquals(1, $mapped_customer_address['id']);
        $this->assertEquals(1, $mapped_customer_address['customer_id']);
        $this->assertEquals('Casa', $mapped_customer_address['name']);
        $this->assertEquals('2° tv', $mapped_customer_address['street']);
        $this->assertEquals('3A', $mapped_customer_address['number']);
        $this->assertEquals('SCV', $mapped_customer_address['neighborhood']);
        $this->assertEquals('Salvador', $mapped_customer_address['city']);
        $this->assertEquals('BA', $mapped_customer_address['state']);
        $this->assertEquals('BR', $mapped_customer_address['country']);
        $this->assertEquals('41500000', $mapped_customer_address['zipcode']);
        $this->assertEquals('Casa de lado', $mapped_customer_address['complement']);

    }

    public function testGetTableName(): void
    {
        $customer = new CustomerAddresses();
        $this->assertEquals('customer_addresses', $customer->getTableName());
    }
}