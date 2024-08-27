<?php

namespace App\Modules\Customers\Http\Controllers;

use App\Core\Interfaces\ControllerInterface;
use App\Modules\Customers\Http\Requests\ShowFormRequest;
use App\Modules\Customers\Repositories\CostumersRepository;

class CustomersController implements ControllerInterface
{

    /**
     * Returns all records
     *
     * @return void
     */
    public function index(): void
    {
        $costumers = (new CostumersRepository)->select();
        echo json_encode($costumers);
    }

    public function create(): void
    {
        // TODO: Implement create() method.
    }

    /**
     * Return a specific record
     *
     * @param array $data
     * @return void
     */
    public function show(array $data): void
    {
        $id = $data[0] ?? null;

        $request = new ShowFormRequest(['id' => $id]);

        // Valida os parâmetros usando o ShowFormRequest
        if ($request->isValid() === false) {
            http_response_code(400);
            echo json_encode(['errors' => $request->getErrors()]);
            return;
        }

        $costumer = (new CostumersRepository)->findById($id);
        echo json_encode($costumer);
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