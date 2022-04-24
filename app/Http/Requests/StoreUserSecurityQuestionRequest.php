<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserSecurityQuestionRequest extends FormRequest
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
            '*.answer' => ['required', 'min:5', 'max:500'],
            '*.question' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            '*.answer' => 'Answers',
            '*.question' => 'Security Question'
        ];
    }
}
