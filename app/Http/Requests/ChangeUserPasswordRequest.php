<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangeUserPasswordRequest extends FormRequest
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
            'currentPassword' => ['required', 'min:8', 'max:500', new MatchOldPassword()],
            'newPassword' => ['required', 'min:8', 'max:500'],
            'confirmedNewPassword' => ['required', 'min:8', 'max:500', 'same:newPassword'],
        ];
    }

    public function attributes()
    {
        return [
            'currentPassword' => 'Current Password',
            'newPassword' => 'New Password',
            'confirmedNewPassword' => 'Confirm New Password'
        ];
    }
}
