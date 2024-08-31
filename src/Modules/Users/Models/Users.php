<?php

namespace App\Modules\Users\Models;

use App\Core\Interfaces\ModelInterface;

/**
 * Users Model Class
 * Contains whole fields from respective table
 *
 * @implements ModelInterface
 */
final class Users implements ModelInterface
{

    private readonly string $table;

    function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
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

    private static function encrypt_password(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
