<?php

namespace App\modules\Customers\Models;
class Customers
{

    function __construct(
        public ?int $id = null,
        public ?int $user_id = null,
        public string $name,
        public string $birthday,
        public string $cpf,
        public string $rg,
        public string $phone,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}
}
