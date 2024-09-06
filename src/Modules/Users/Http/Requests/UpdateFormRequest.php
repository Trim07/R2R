<?php

namespace App\Modules\Users\Http\Requests;

use App\Core\FormRequest\FormRequest;


/**
 * Used to validate form requests
 */
class UpdateFormRequest extends FormRequest
{

    /**
     * Defines validation rules for users requests.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'user' => [
                "id" => "required|int",
                "name" => "required|string|max:100",
                "email" => "required|string|max:100",
                "password" => "required|string|max:100"
            ]
        ];
    }
}
