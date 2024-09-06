<?php

namespace App\Modules\Users\Models;

use App\Core\Interfaces\ModelInterface;

/**
 * Users Model Class
 * Contains whole fields from respective table
 */
final class Users implements ModelInterface
{

    private readonly string $table;

    function __construct(
        public readonly ?int $id = null,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
    ) {
        $this->table = "users";
    }

    /**
     * @param array $array
     * @return self
     */
    public static function mapFieldFromArray(array $array): self
    {
        return new self(
            id: $array['id'] ?? null,
            name: $array['name'] ?? null,
            email: $array['email'] ?? null,
            password: $array['password'] ?? null,
            created_at: $array['created_at'] ?? null,
            updated_at: $array['updated_at'] ?? null
        );
    }

    /**
     * @return array
     */
    public function mapFieldsToArray(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "password" => $this->password,
        ];
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table;
    }
}
