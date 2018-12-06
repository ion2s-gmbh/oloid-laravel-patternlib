<?php

namespace Laratomics\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laratomics\Rules\UniquePattern;

class CreatePattern extends FormRequest
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
            'name' => ['required', new UniquePattern]
        ];
    }
}
