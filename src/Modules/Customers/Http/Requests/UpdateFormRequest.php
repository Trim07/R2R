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
            'customer' => [
                "id" => "required|int",
                "name" => "required|string|max:100",
                "birthday" => "required|date",
                "cpf" => "required|string|max:11",
                "rg" => "required|string|max:9",
                "phone" => "required|string|max:11"
            ],
            'addresses' => [
                '*' => [ // '*' indica qualquer índice numérico (array de objetos)
                    "id" => "required|int",
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
