<?php

namespace App\Modules\Customers\Http\Controllers;

use App\Core\Interfaces\ControllerInterface;
use App\Modules\Customers\Repositories\CostumersRepository;

class CustomersController implements ControllerInterface
{

    /**
     * Returns records
     *
     * @return void
     */
    public function index(): void
    {
        $costumers = (new CostumersRepository)->select();
        echo json_encode($costumers);
        return;
    }

    public function create(): void
    {
        // TODO: Implement create() method.
    }

    public function show(int $id): void
    {
        $costumers = (new CostumersRepository)->findById($id);
        echo json_encode($costumers);
    }

    public function update(int $id): void
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
}