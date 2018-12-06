<?php

namespace Laratomics\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laratomics\Rules\UniquePattern;

class UpdatePattern extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['sometimes', 'required', new UniquePattern]
        ];
    }
}
