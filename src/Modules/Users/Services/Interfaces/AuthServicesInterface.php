<?php

namespace App\Modules\Users\Services\Interfaces;

interface AuthServicesInterface
{

    /**
     * @param array $data
     * @return bool
     */
    public function login(array $data): bool;

    /**
     * @return void
     */
    public function logout(): void;

    /**
     * @return bool
     */
    public function isLoggedIn(): bool;

}