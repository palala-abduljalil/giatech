<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangeUserSecurityQuestionRequest extends FormRequest
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
            'password' => ['required', 'max:500', new MatchOldPassword()],
            'answer' => ['required', 'min:5', 'max:500'],
            'security_question' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'Password',
            'answer' => 'Answer',
            'security_question' => 'Security Question'
        ];
    }
}
