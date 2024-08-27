<?php

namespace App\Modules\Customers\Models;

class Customers
{

    public readonly string $table;

    function __construct(
        public ?string $name = null,
        public ?string $birthday = null,
        public ?string $cpf = null,
        public ?string $rg = null,
        public ?string $phone = null,

        public ?int $id = null,
        public ?int $user_id = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {
        $this->table = "customers";
    }
}
