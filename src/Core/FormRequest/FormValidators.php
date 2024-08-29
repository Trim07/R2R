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
     * @param string|null $field
     * @param string|null $value
     * @return bool
     */
    public function validateRequired(string|null $field, string|null $value): bool
    {
        $isValid = strlen($value) !== 0 && !empty($field);
        if ($isValid === false) {
            $this->errors[$field][] = "O campo $field é obrigatório.";
            return false;
        }
        return true;
    }

    /**
     * Validate maximum fields value size
     *
     * @param string|null $field
     * @param string|null $value
     * @param string $rule
     * @return bool
     */
    public function validateMax(string|null $field, string|null $value, string $rule): bool
    {
        $max = (int)str_replace('max:', '', $rule);

        $isValid = strlen($value) !== 0 && !empty($field) && !(strlen($value) > $max);
        if ($isValid === false) {
            $this->errors[$field][] = "O campo $field não pode ser maior que $max caracteres.";
            return false;
        }
        return true;
    }

    /**
     * Validate minimum fields value size
     *
     * @param string|null $field
     * @param string|null $value
     * @param string $rule
     * @return bool
     */
    public function validateMin(string|null $field, string|null $value, string $rule): bool
    {
        $min = (int)str_replace('min:', '', $rule);

        $isValid = strlen($value) !== 0 && !empty($field) && !strlen($value) > $min;
        if ($isValid === false) {
            $this->errors[$field][] = "O campo $field não pode ser menor que $min caracteres.";
            return false;
        }
        return true;
    }

    /**
     * Validate if field is string type
     *
     * @param string|null $field
     * @param string|null $value
     * @return bool
     */
    public function validateString(string|null $field, string|null $value): bool
    {
        $isValid = is_string($value) && !empty($value) && strlen($value) !== 0;
        if ($isValid === false) {
            $this->errors[$field][] = "O campo $field deve ser válido.";
            return false;
        }
        return true;
    }

    /**
     * Validate if field is integer type
     *
     * @param string|null $field
     * @param int|null $value
     * @return bool
     */
    public function validateInt(string|null $field, int|null $value): bool
    {
        $isValid = !empty($field) && strlen($value) !== 0;
        if ($isValid === false) {
            $this->errors[$field][] = "O campo $field deve ser válido.";
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