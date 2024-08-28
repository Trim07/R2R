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
            'customer' => [
                "name" => "string|max:100",
                "birthday" => "date",
                "cpf" => "string|max:11",
                "rg" => "string|max:9",
                "phone" => "string|max:11"
            ],
            'addresses' => [
                '*' => [ // '*' indica qualquer índice numérico (array de objetos)
                    "name" => "required|string",
                    "street" => "required|string",
                    "number" => "required|string",
                    "neighborhood" => "required|string",
                    "city" => "required|string",
                    "state" => "required|string",
                    "country" => "required|string",
                    "zipcode" => "required|string",
                    "complement" => "string",
                ]
            ]
        ];
    }
}
