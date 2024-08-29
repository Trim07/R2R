<?php

namespace App\Modules\Users\Http\Controllers;

use App\Core\Exceptions\AuthException;
use App\Core\Exceptions\FormRequestValidationException;
use App\Core\Interfaces\ControllerInterface;
use App\Modules\Users\Http\Requests\CreateFormRequest;
use App\Modules\Users\Http\Requests\DeleteFormRequest;
use App\Modules\Users\Http\Requests\LoginFormRequest;
use App\Modules\Users\Http\Requests\ShowFormRequest;
use App\Modules\Users\Http\Requests\UpdateFormRequest;
use App\Modules\Users\Repositories\UsersRepository;
use App\Modules\Users\Services\AuthService;
use App\Modules\Users\Services\UsersServices;


/**
 * @implements ControllerInterface
 */
class UsersController implements ControllerInterface
{

    function __construct(
        private readonly UsersRepository $usersRepository = new UsersRepository(),
        private readonly UsersServices $usersServices = new UsersServices(),
        private readonly AuthService $authService = new AuthService()
    ){}

    /**
     * Returns all records
     *
     * @return void
     */
    public function index(): void
    {
        $costumers = $this->usersRepository->select();
        echo json_encode($costumers);
    }

    /**
     * Create a user  record
     *
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        try {
            $validatedData = (new CreateFormRequest($data))->validated();
            $this->usersServices->create($validatedData);
        }catch (\Exception $exception){
            http_response_code(500);
            echo json_encode($exception->getMessage());
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
        try {
            $id = (int)$data[0] ?? null;

            $request = new ShowFormRequest(['id' => $id]);

            // Valida os parâmetros usando o ShowFormRequest
            if ($request->isValid() === false) {
                http_response_code(400);
                echo json_encode(['errors' => $request->getErrors()]);
                return;
            }

            $costumer = $this->usersRepository->findById($id);
            http_response_code(200);
            echo json_encode($costumer);

        }catch (FormRequestValidationException $exception){
            http_response_code(500);
            echo json_encode([
                'message' => $exception->getMessage(),
                'errors' => $exception->getErrors(),
            ]);
        }catch (\Exception $exception){
            http_response_code(500);
            echo json_encode($exception->getMessage());
        }
    }

    /**
     * Update user record
     *
     * @param array $data
     * @return void
     */
    public function update(array $data): void
    {
        try {
            $validatedData = (new UpdateFormRequest($data))->validated();
            $this->usersServices->update($validatedData);
        }catch (\Exception $exception){
            http_response_code(500);
            echo json_encode($exception->getMessage());
        }
    }

    /**
     * Delete user record
     *
     * @param array $data
     * @return void
     */
    public function delete(array $data): void
    {
        try {
            $id = (Int)$data[0] ?? null;
            $request = new DeleteFormRequest(['id' => $id]);

            // Valida os parâmetros usando o ShowFormRequest
            if ($request->isValid() === false) {
                http_response_code(400);
                echo json_encode(['errors' => $request->getErrors()]);
                return;
            }

            $this->usersServices->delete($request->validated());
            http_response_code(204);

        }catch (\Exception $exception){
            http_response_code(500);
            echo $exception->getMessage();
        }
    }

    /**
     * @param array $data
     * @return void
     * @throws FormRequestValidationException
     */
    public function login(array $data): void
    {
        try {
            $request = new LoginFormRequest($data);
            $this->authService->login($request->validated());
            http_response_code(200);
        }catch (AuthException $exception){
            http_response_code(401);
            echo $exception->getMessage();
        }
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        try {
            $this->authService->logout();
            http_response_code(200);
        }catch (AuthException $exception){
            http_response_code(401);
            echo $exception->getMessage();
        }
    }
}