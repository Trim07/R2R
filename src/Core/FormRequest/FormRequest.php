<?php

namespace App\Core\FormRequest;

use App\Core\Exceptions\FormRequestValidationException;

/**
 * Base class for handling form requests and validations.
 */
abstract class FormRequest
{
    protected array $data;
    protected array $rules = [];
    protected array $errors = [];

    /**
     * @throws FormRequestValidationException
     */
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
     * @return void
     * @throws FormRequestValidationException
     */
    public function validate(array $data): void
    {
        $formValidators = new FormValidators();
        $formValidators->validate($data, $this->rules());
        $this->errors = $formValidators->getErrors();

        if (!empty($this->errors)) {
            throw new FormRequestValidationException('Ocorreram erros durante a validação dos dados informados', $this->errors, 400);
        }
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
     * Return only fields that contains in rules() function
     *
     * @return array
     */
    public function validated(): array
    {
        return $this->filterData($this->data, $this->rules());
    }

    /**
     * Helper method to filter data based on rules.
     *
     * @param array $data
     * @param array $rules
     * @return array
     */
    protected function filterData(array $data, array $rules): array
    {
        $filteredData = [];

        foreach ($rules as $key => $rule) {
            if (isset($data[$key])) {
                if (is_array($rule)) {
                    // Handle nested arrays
                    if (is_array($data[$key])) {
                        // Recursive filtering for nested data
                        if (isset($rule['*']) && is_array($rule['*'])) {
                            // Handle arrays of objects
                            $filteredData[$key] = [];
                            foreach ($data[$key] as $index => $item) {
                                if (is_array($item)) {
                                    $filteredData[$key][$index] = $this->filterData($item, $rule['*']);
                                }
                            }
                        } else {
                            // Handle other nested structures
                            $filteredData[$key] = $this->filterData($data[$key], $rule);
                        }
                    }
                } else {
                    // Include fields that are present in the rules
                    $filteredData[$key] = $data[$key];
                }
            }
        }
        return $filteredData;
    }
}