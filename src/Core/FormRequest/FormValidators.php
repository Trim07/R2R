<?php

namespace App\Core\FormRequest;

class FormValidators
{

    private array $errors = [];

    /**
     * Can be used to do validations using rules
     *
     * @param array $rules
     * @param array $data
     * @return void
     */
    public function validate(array $rules, array $data): void
    {
        foreach ($rules as $field => $ruleString) {
            $rulesArray = explode('|', $ruleString);

            foreach ($rulesArray as $rule) {

                match ($rule) {
                    $rule === "required" => $this->validateRequired($field, $data[$field]),
                    $rule === "string" => $this->validateString($field, $data[$field]),
                    $rule === "int" => $this->validateInt($field, $data[$field]),
                    str_contains($rule, 'max:') => $this->validateMax($field, $data[$field], $rule),
                    str_contains($rule, 'min:') => $this->validateMin($field, $data[$field], $rule),
                    default => null,
                };
            }
        }
    }

    /**
     * Validate required fields
     *
     * @param string $field
     * @param string $value
     * @return bool
     */
    public function validateRequired(string $field, string $value): bool
    {
        $valueIsEmpty = empty($value);
        if ($valueIsEmpty) {
            $this->errors[$field][] = "The $field is required.";
            return false;
        }
        return true;
    }

    /**
     * Validate maximum fields value size
     *
     * @param string $field
     * @param string $value
     * @param string $rule
     * @return bool
     */
    public function validateMax(string $field, string $value, string $rule): bool
    {
        $max = (int) str_replace('max:', '', $rule);

        if ($value > $max) {
            $this->errors[$field][] = "The $field may not be greater than $max characters.";
            return false;
        }
        return true;
    }

    /**
     * Validate minimum fields value size
     *
     * @param string $field
     * @param string $value
     * @param string $rule
     * @return bool
     */
    public function validateMin(string $field, string $value, string $rule): bool
    {
        $min = (int) str_replace('min:', '', $rule);

        if ($value < $min) {
            $this->errors[$field][] = "The $field may not be less than $min characters.";
            return false;
        }
        return true;
    }

    /**
     * Validate if field is string type
     *
     * @param string $field
     * @param string $value
     * @return bool
     */
    public function validateString(string $field, string $value): bool
    {
        $isString = !is_string($value);
        if ($isString) {
            $this->errors[$field][] = "The $field must be a string.";
            return false;
        }
        return true;
    }

    /**
     * Validate if field is integer type
     *
     * @param string $field
     * @param string $value
     * @return bool
     */
    public function validateInt(string $field, string $value): bool
    {
        $isString = !is_numeric($value);
        if ($isString) {
            $this->errors[$field][] = "The $field must be a integer.";
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}