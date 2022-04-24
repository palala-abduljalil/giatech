<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStakeholderRequest extends FormRequest
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
            'employee' => ['required', 'integer', 'unique:stakeholder,employee_id'],
            'link' => ['required', 'max:255', 'url'],
            'company_id' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'link.url' => 'The link field is not a valid URL or Address',
            'employee.unique' => 'This employee is already a stakeholder.'
        ];
    }

    public function attributes()
    {
        return [
            'employee' => 'Employee',
            'link' => 'LinkedIn Link'
        ];
    }
}
