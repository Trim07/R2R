<?php declare(strict_types = 1);

namespace App\Modules\Customers\Tests\Models;

use App\Modules\Customers\Models\Customers;
use PHPUnit\Framework\TestCase;

final class CustomersTest extends TestCase
{

    public function testCanBeCreatedFromValidArray()
    {
        $data = [
            'id' => 1,
            'user_id' => 1,
            'name' => 'Henrique Garlach',
            'birthday' => '1988-12-31',
            'cpf' => '12345678910',
            'rg' => 'BA1234567',
            'phone' => '71982407264',
            'created_at' => '2024-08-31 17:30:10',
            'updated_at' => '2024-08-31 17:30:10',
        ];

        $mapped_customer = Customers::mapFieldFromArray($data);

        $this->assertInstanceOf(Customers::class, $mapped_customer);
    }

    public function testCanMapFieldsToArray()
    {
        $customer = new Customers(
            id: 1,
            user_id: 1,
            name: 'Henrique Garlach',
            birthday: '1988-12-31',
            cpf: '12345678910',
            rg: 'BA1234567',
            phone: '71982407264',
            created_at: '2024-08-31 17:30:10',
            updated_at: '2024-08-31 17:30:10'
        );

        $customer_array = $customer->mapFieldsToArray();

        $this->assertIsArray($customer_array);
        $this->assertEquals(1, $customer_array['id']);
        $this->assertEquals(1, $customer_array['user_id']);
        $this->assertEquals('Henrique Garlach', $customer_array['name']);
        $this->assertEquals('1988-12-31', $customer_array['birthday']);
        $this->assertEquals('12345678910', $customer_array['cpf']);
        $this->assertEquals('BA1234567', $customer_array['rg']);
        $this->assertEquals('71982407264', $customer_array['phone']);
    }

    public function testGetTableName()
    {
        $customer = new Customers();
        $this->assertEquals('customers', $customer->getTableName());
    }

}