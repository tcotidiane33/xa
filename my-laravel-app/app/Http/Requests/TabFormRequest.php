<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TabFormRequest extends FormRequest
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
            // Define your validation rules for the tabulated form fields here
        ];
    }

    /**
     * Get the validation messages for the defined rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // Define your validation messages for the tabulated form fields here
        ];
    }
}