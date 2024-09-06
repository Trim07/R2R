<?php

namespace App\Modules\Users\Http\Requests;

use App\Core\FormRequest\FormRequest;


/**
 * Used to validate form requests
 */
class DeleteFormRequest extends FormRequest
{

    /**
     * Defines validation rules for user requests.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'id' => 'required|int',
        ];
    }
}
