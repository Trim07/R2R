<?php

namespace App\Modules\Users\Repositories;

use App\Core\AbstractClasses\BaseRepository;
use App\Modules\Users\Models\Users;

/**
 * Read data from costumers table
 *
 * @extends BaseRepository
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
        $users = $this->table($this->users->getTableName())->select()->where("id", "=", $id)->get();
        if(empty($users)){
            http_response_code(204);
            throw new \Exception("Usuário não encontrado");
        }
        return $users[0];
    }
}