<?php

namespace App\Modules\Users\Services;


use App\Core\Interfaces\ServicesInterface;
use App\Core\Services\DatabaseServices;
use App\Modules\Users\Models\Users;

/**
 * Can be used to access external services or manipulate the database, for example
 *
 * @implements ServicesInterface
 */
class UsersServices implements ServicesInterface
{

    function __construct(
        private readonly DatabaseServices $databaseServices = new DatabaseServices(),
    ){}

    /**
     * Create a new record
     *
     * @param array $data
     * @return void
     */
    function create(array $data): void
    {
        $data["user"]["password"] = password_hash($data["password"], PASSWORD_BCRYPT);
        $userModel = $this->mapFields($data["user"]);
        $this->databaseServices->insert($userModel); // insert users into table
    }

    /**
     * Update a record
     *
     * @param array $data
     * @return void
     */
    function update(array $data): void
    {
        $userModel = $this->mapFields($data["user"]);
        $this->databaseServices->update($userModel); // update user
    }

    /**
     * Delete a record
     *
     * @param array $data
     * @return void
     */
    function delete(array $data): void
    {
        $modelMappedFields = $this->mapFields($data);
        $this->databaseServices->delete($modelMappedFields);
    }

    /**
     * Map fields to Users model
     *
     * @param array $data
     * @return Users
     */
    public function mapFields(array $data): Users
    {
        return Users::mapFieldFromArray($data);
    }

    private function encrypt_password(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}