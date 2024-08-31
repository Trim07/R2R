<?php

namespace App\Core\Exceptions;

use App\Core\AbstractClasses\BaseException;
use JetBrains\PhpStorm\NoReturn;

/**
 * @extends \Exception
 */
class FormRequestValidationException extends BaseException
{
    protected array $errors;

    /**
     * @param string $message
     * @param int $code
     * @param array $errors
     */

    #[NoReturn]
     public function __construct(string $message, array $errors = [], int $code = 400)
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
        http_response_code($this->getCode());
        echo json_encode([
            'error' => $this->getMessage(),
            'details' => $this->getErrors()
        ]);
        exit;
    }
}