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
                "name" => "required|string|max:100",
                "birthday" => "required|date",
                "cpf" => "required|string|max:11",
                "rg" => "required|string|max:10",
                "phone" => "required|string|max:11"
            ],
            'addresses' => [
                '*' => [ // '*' indicates any numeric index (array of objects)
                    "name" => "required|string|max:30",
                    "street" => "required|string|max:50",
                    "number" => "required|string|max:10",
                    "neighborhood" => "required|string|max:30",
                    "city" => "required|string|max:50",
                    "state" => "required|string|max:4",
                    "country" => "required|string|max:3",
                    "zipcode" => "required|string|max:8",
                    "complement" => "string|max:50",
                ]
            ]
        ];
    }
}
