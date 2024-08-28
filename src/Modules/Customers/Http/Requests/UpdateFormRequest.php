<?php

namespace App\Modules\Customers\Http\Requests;

use App\Core\FormRequest\FormRequest;


/**
 * Used to validate form requests
 *
 * @extends FormRequest
 */
class UpdateFormRequest extends FormRequest
{

    /**
     * Defines validation rules for customer requests.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
              "id" => "int",
              "name" => "string|max:100",
              "birthday" => "date",
              "cpf" => "string",
              "rg" => "string",
              "phone" => "string"
        ];
    }
}
