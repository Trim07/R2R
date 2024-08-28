<?php

namespace App\Modules\Customers\Models;

use App\Core\Interfaces\ModelInterface;

/**
 * Customers Model Class
 * Contains whole fields from respective table
 *
 * @implements ModelInterface
 */
class Customers implements ModelInterface
{

    private readonly string $table;

    function __construct(
        public ?int $id = null,
        public ?int $user_id = null,
        public ?string $name = null,
        public ?string $birthday = null,
        public ?string $cpf = null,
        public ?string $rg = null,
        public ?string $phone = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {
        $this->table = "customers";
    }

    /**
     * @param array $array
     * @return self
     */
    public static function mapFieldFromArray(array $array): self
    {
        return new self(
            id: $array['id'] ?? null,
            user_id: $array['user_id'] ?? null,
            name: $array['name'] ?? null,
            birthday: $array['birthday'] ?? null,
            cpf: $array['cpf'] ?? null,
            rg: $array['rg'] ?? null,
            phone: $array['phone'] ?? null,
            created_at: $array['created_at'] ?? null,
            updated_at: $array['updated_at'] ?? null
        );
    }

    /**
     * @return array
     */
    function mapFieldsToArray(): array
    {
        return [
            "id" => $this->id,
//            "user_id" => $this->user_id,
            "name" => $this->name,
            "birthday" => $this->birthday,
            "cpf" => $this->cpf,
            "rg" => $this->rg,
            "phone" => $this->phone
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
