<?php

namespace App\Core\Exceptions;

/**
 * @extends \Exception
 */
class FormRequestValidationException extends \Exception
{
    protected array $errors;

    /**
     * @param string $message
     * @param int $code
     * @param array $errors
     */
    public function __construct(string $message, int $code = 400, array $errors = [])
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}