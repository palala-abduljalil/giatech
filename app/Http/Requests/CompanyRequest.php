<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'emailAddress' => ['email', 'max:255'],
            'websiteAddress' => ['max:255', 'url'],
            'landlineNumber' => ['min:5', 'max:255'],
            'mobileNumber' => ['min:5', 'max:255'],
            'socialMediaAccounts.*.link' => ['max:255', "regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/"],
        ];
    }

    public function attributes()
    {
        return [
            'emailAddress' => 'E-Mail Address',
            'websiteAddress' => 'Website Address',
            'landlineNumber' => 'Landline Number',
            'mobileNumber' => 'Mobile Number',
            'socialMediaAccounts.*.link' => 'Link'
        ];
    }
}
