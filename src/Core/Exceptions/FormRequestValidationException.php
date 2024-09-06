<?php

namespace App\Core\Exceptions;

use App\Core\AbstractClasses\BaseException;


class FormRequestValidationException extends BaseException
{
    protected array $errors;

    /**
     * @param string $message
     * @param int $code
     * @param array $errors
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
        http_response_code($this->getCode());
        echo json_encode([
            'error' => $this->getMessage(),
            'details' => $this->getErrors()
        ]);
        exit;
    }
}