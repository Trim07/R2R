<?php

namespace App\Core\AbstractClasses;

/**
 * @extends \Exception
 */
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
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return void
     */
    abstract function handle(): void;
}