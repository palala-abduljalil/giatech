<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'employee' => ['required', 'string', 'max:500', 'unique:user,username'],
            'modules' => ['required', 'array']
        ];
    }

    public function attributes()
    {
        return [
            'employee' => 'Employee',
            'modules' => 'Module',
        ];
    }

    public function messages()
    {
        return [
            'employee.unique' => 'Employee has an account.',
            'modules.required' => 'Select Module.'
        ];
    }
}
