<?php


namespace App\Modules\Customers\Models;

use App\Core\Interfaces\ModelInterface;

/**
 * Customer Model Class
 * Contains whole fields from respective table
 *
 * @implements ModelInterface
 */
final class Customers implements ModelInterface
{

    private readonly string $table;

    function __construct(
        private ?int $id = null,
        private ?int $user_id = null,
        private ?string $name = null,
        private ?string $birthday = null,
        private ?string $cpf = null,
        private ?string $rg = null,
        private ?string $phone = null,
        private ?string $created_at = null,
        private ?string $updated_at = null,
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
            "user_id" => $this->user_id,
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
