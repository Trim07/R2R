<?php

namespace App\Modules\Customers\Http\Requests;

use App\Core\FormRequest\FormRequest;


/**
 * Used to validate form requests
 *
 * @extends FormRequest
 */
class CreateFormRequest extends FormRequest
{

    /**
     * Defines validation rules for customer requests.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
              "name" => "string|max:100",
              "birthday" => "date",
              "cpf" => "string|max:11",
              "rg" => "string|max:9",
              "phone" => "string|max:11"
        ];
    }
}
