<?php

namespace App\Core\FormRequest;

use App\Core\Exceptions\FormRequestValidationException;

/**
 * Contains all validations functions to form validation
 */
class FormValidators
{

    private array $errors = [];

    /**
     * Can be used to do validations using rules
     *
     * @param array $data
     * @param array $rules
     * @return void
     * @throws FormRequestValidationException
     */

    public function validate(array $data, array $rules): void
    {
        foreach ($rules as $key => $rule) {
            if (is_array($rule)) {
                // Recursive validation for nested arrays
                if (isset($data[$key]) && is_array($data[$key])) {
                    $this->validate($data[$key], $rule);
                }
            } else {
                // Validate the field based on the rule
                $this->validateField($key, $data[$key] ?? null, $rule);
            }
        }
    }

    /**
     * Validates nested fields.
     *
     * @param array $data
     * @param array $rules
     * @param string $parentKey
     * @return void
     * @throws FormRequestValidationException
     */
    private function validateNested(array $data, array $rules, string $parentKey): void
    {
        foreach ($rules as $field => $ruleSet) {
            $key = "{$parentKey}.{$field}";
            if (is_array($ruleSet)) {
                $this->validateNested($data[$field] ?? [], $ruleSet, $key);
            } else {
                $this->validateField($key, $data[$field] ?? null, $ruleSet);
            }
        }
    }

    /**
     * Validates a single field.
     *
     * @param string $field
     * @param mixed $value
     * @param string $rule
     * @return void
     * @throws FormRequestValidationException
     */
    protected function validateField(string $field, mixed $value, string $rule): void
    {
        $rules = explode('|', $rule);

        foreach ($rules as $rule) {
            if($rule === "required"){
                $this->validateRequired($field, $value);

            }else if($rule === "string"){
                $this->validateString($field, $value);

            }else if($rule === "int"){
                $this->validateInt($field, $value);

            }else if(str_contains($rule, 'max:')){
                $this->validateMax($field, $value, $rule);

            }else if(str_contains($rule, 'min:')){
                $this->validateMin($field, $value, $rule);
            }else{
                throw new  FormRequestValidationException("O validador do campo $field não existe", 400);
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
        $max = (int)str_replace('max:', '', $rule);

        if (strlen($value) > $max) {
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
        $min = (int)str_replace('min:', '', $rule);

        if (strlen($value) < $min) {
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