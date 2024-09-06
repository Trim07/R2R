<?php

namespace App\Core\Exceptions;

use App\Core\AbstractClasses\BaseException;


class UserException extends BaseException
{
    /**
     * @param string $message
     * @param array $errors
     * @param int $code
     */
    public function __construct(string $message, array $errors = [], int $code = 400)
    {
        parent::__construct($message, $errors, $code);
        $this->errors = $errors;
        $this->handle();
    }

    /**
     * @return void
     */
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