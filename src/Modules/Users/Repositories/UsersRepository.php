<?php

namespace App\Modules\Users\Repositories;

use App\Core\AbstractClasses\BaseRepository;
use App\Modules\Users\Models\Users;
use http\Client\Curl\User;

/**
 * Read data from costumers table
 */
class UsersRepository extends BaseRepository
{

    function __construct(
        private readonly Users $users = new Users
    ){
        parent::__construct();
        $this->table = $this->users->getTableName();
    }

    /**
     * find record by id
     *
     * @param int $id ID of record
     * @return array
     * @throws \Exception
     */
    public function findById(int $id): array
    {
        $users = $this->findOrFail($id);

        return [
            "user" => $users,
        ];
    }

    /**
     *
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function findOrFail(int $id): array
    {
        $users = $this->select()->where("id", "=", $id)->get();
        if(empty($users)){
            http_response_code(204);
            throw new \Exception("Usuário não encontrado");
        }
        return $users[0];
    }

    /**
     * @param Users $user
     * @return bool
     */
    public function checkIfCustomerExists(Users $user): bool
    {
        $search_customer = $this->where("email", "=", $user->email)->first();
        return !empty($search_customer);
    }
}