<?php

namespace App\Modules\Users\Services;

use App\Core\Exceptions\AuthException;
use App\Modules\Users\Models\Users;
use App\Modules\Users\Repositories\UsersRepository;
use App\Modules\Users\Services\Interfaces\AuthServicesInterface;

/**
 * Responsible for control of authentication
 *
 * @implements AuthServicesInterface
 */
class AuthService implements AuthServicesInterface
{

    function __construct(
        private readonly UsersRepository $usersRepository = new UsersRepository,
        private readonly UsersServices   $usersServices = new UsersServices
    ){}

    /**
     * @param array $data
     * @return bool
     * @throws AuthException
     */
    public function login(array $data): bool
    {
        $getUser = $this->usersRepository->where("email", "=", $data["email"])->first();
        $user = $this->usersServices->mapFields($getUser);
        if ($user->id && password_verify($data["password"], $user->password)) {
            $this->startSession($user);
            return true;
        }
        throw new AuthException("Credenciais incorretas", [], 401);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        session_start();
        $_SESSION = [];
        $session_timeout = $_ENV['SESSION_TIMEOUT'];
        if (session_id() !== '') {
            setcookie(session_name(), '', time() - $session_timeout, '/');
        }
        session_destroy();
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        session_start();
        return isset($_SESSION['user']) && $_SESSION['user']['logged_in'] === true;
    }

    /**
     * @param Users $user
     * @return void
     */
    private function startSession(Users $user): void
    {
        session_start();
        $_SESSION['user'] = [
            'id' => $user->id,
            'email' => $user->email,
            'logged_in' => true,
        ];
    }
}