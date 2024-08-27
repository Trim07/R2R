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
        $this->validate();
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
     * @return void
     */
    protected function validate(): void
    {
        $this->rules = $this->rules();
        foreach ($this->rules as $field => $rule) {
            if (!$this->applyRule($field, $rule)) {
                $this->errors[$field] = "O campo $field é inválido.";
            }
        }
    }

    /**
     * Applies a validation rule to a field.
     *
     * @param string $field
     * @param string $rule
     * @return bool
     */
    protected function applyRule(string $field, string $rule): bool
    {
        $value = $this->data[$field] ?? null;
        return match ($rule) {
            "required" => is_null($value),
            "int" => is_numeric($value),
            "min", "max" => $rule,
            default => $value,
        };
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
}