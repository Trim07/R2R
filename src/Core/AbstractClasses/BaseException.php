<?php

namespace App\Core\AbstractClasses;

abstract class BaseException extends \Exception
{
    protected array $errors;

    /**
     * @param string $message
     * @param array $errors
     * @param int $code
     */
    public function __construct(string $message, array $errors = [], int $code = 500)
    {
        $this->errors = $errors;
        parent::__construct($message, $code);
    }

    /**
     * Get array errors
     * 
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Abstract function to handle errors
     * 
     * @return void
     */
    abstract function handle(): void;
}