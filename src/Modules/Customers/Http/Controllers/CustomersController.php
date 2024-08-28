<?php

namespace App\Modules\Customers\Http\Controllers;

use App\Core\Interfaces\ControllerInterface;
use App\Modules\Customers\Http\Requests\CreateFormRequest;
use App\Modules\Customers\Http\Requests\DeleteFormRequest;
use App\Modules\Customers\Http\Requests\ShowFormRequest;
use App\Modules\Customers\Http\Requests\UpdateFormRequest;
use App\Modules\Customers\Repositories\CustomersRepository;
use App\Modules\Customers\Services\CustomersServices;


/**
 * @implements ControllerInterface
 */
class CustomersController implements ControllerInterface
{

    function __construct(
        private readonly CustomersRepository $custumersRepository = new CustomersRepository(),
        private readonly CustomersServices $customersServices = new CustomersServices()
    ){}

    /**
     * Returns all records
     *
     * @return void
     */
    public function index(): void
    {
        $costumers = $this->custumersRepository->select();
        echo json_encode($costumers);
    }

    /**
     * Create a customer record
     *
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        try {
            $validatedData = (new CreateFormRequest($data))->validated();
            $modelMappedFields = $this->customersServices->mapFields($validatedData);
            $this->customersServices->create($modelMappedFields);
            echo 123;
        }catch (\Exception $exception){
            http_response_code(500);
            echo $exception->getMessage();
        }
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

        $costumer = $this->custumersRepository->findById($id);
        http_response_code(200);
        echo json_encode($costumer);
    }

    /**
     * Update customer record
     *
     * @param array $data
     * @return void
     */
    public function update(array $data): void
    {
        try {
            $validatedData = (new UpdateFormRequest($data))->validated();
            $modelMappedFields = $this->customersServices->mapFields($validatedData);
            $this->customersServices->update($modelMappedFields);
            echo 123;
        }catch (\Exception $exception){
            http_response_code(500);
            echo $exception->getMessage();
        }
    }

    /**
     * Delete customer record
     *
     * @param array $data
     * @return void
     */
    public function delete(array $data): void
    {
        try {
            $id = $data[0] ?? null;
            $request = new DeleteFormRequest(['id' => $id]);

            // Valida os parâmetros usando o ShowFormRequest
            if ($request->isValid() === false) {
                http_response_code(400);
                echo json_encode(['errors' => $request->getErrors()]);
                return;
            }

            $modelMappedFields = $this->customersServices->mapFields(['id' => $id]);
            $this->customersServices->delete($modelMappedFields);
            http_response_code(204);
        }catch (\Exception $exception){
            http_response_code(500);
            echo $exception->getMessage();
        }
    }
}