<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FreebieRequest extends FormRequest
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
            'name' => ['required', 'min:5', 'max:255'],
            'image' => ['mimes:jpeg,jpg,png', 'max:2048']
        ];
    }

    public function messages()
    {
        return [
            'image.mimes' => 'The extension of the file must be in jpg, jpeg, or png.'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'image' => 'Cover Image'
        ];
    }
}
