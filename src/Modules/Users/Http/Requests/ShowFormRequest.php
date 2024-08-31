<?php

namespace App\Modules\Users\Http\Requests;

use App\Core\FormRequest\FormRequest;


/**
 * Used to validate form requests
 *
 * @extends FormRequest
 */
class ShowFormRequest extends FormRequest
{

    /**
     * Defines validation rules for user requests.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'id' => 'int',
        ];
    }
}
