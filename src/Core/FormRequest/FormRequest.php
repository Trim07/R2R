<?php

namespace App\Core\FormRequest;

/**
 * Base class for handling form requests and validations.
 */
abstract class FormRequest
{
    protected array $data;
    protected array $rules = [];
    protected array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validate($data);
    }

    /**
     * Abstract method for defining validation rules.
     *
     * @return array
     */
    abstract protected function rules(): array;

    /**
     * Validates the request data based on defined rules.
     *
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        $rules = $this->rules();
        $formValidators = new FormValidators();
        $formValidators->validate($data, $rules);
        $this->errors = $formValidators->getErrors();

        return empty($this->errors);
    }

    /**
     * Checks if the request is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Gets validation errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Return only fields that contains in rule() function
     *
     * @return array
     */
    public function validated(): array
    {
        return array_filter(
            $this->data,
            function ($key) {
                return array_key_exists($key, $this->rules);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}