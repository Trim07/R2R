<?php

namespace App\Core\Exceptions;

use App\Core\AbstractClasses\BaseException;
use JetBrains\PhpStorm\NoReturn;

/**
 * @extends \Exception
 */
class AuthException extends BaseException
{
    /**
     * @param string $message
     * @param array $errors
     * @param int $code
     */
    #[NoReturn]
    public function __construct(string $message, array $errors = [], int $code = 401)
    {
        parent::__construct($message, $errors, $code);
        $this->errors = $errors;
        $this->handle();
    }

    /**
     * @return void
     */
    #[NoReturn]
    public function handle(): void
    {
        header('Content-Type: application/json');
        http_response_code($this->getCode());
        echo json_encode([
            'error' => $this->getMessage(),
            'details' => $this->getErrors()
        ]);
        exit;
    }
}