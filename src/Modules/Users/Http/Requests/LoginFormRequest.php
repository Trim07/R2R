<?php

namespace App\Modules\Users\Http\Requests;

use App\Core\FormRequest\FormRequest;


/**
 * Used to validate form requests
 *
 * @extends FormRequest
 */
class LoginFormRequest extends FormRequest
{

    /**
     * Defines validation rules for user requests.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            "email" => "required|string|max:100",
            "password" => "required|string|max:100"
        ];
    }
}
