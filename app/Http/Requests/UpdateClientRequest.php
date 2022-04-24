<?php

namespace App\Http\Requests;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
        Debugbar::info($this->request);
        return [
            'firstName' => ['required', 'max:255'],
            'middleName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'suffix' => ['max:255'],
            'houseNumber' => ['max:255'],
            'streetName' => ['required','max:500'],
            'region' => ['required'],
            'province' => ['required'],
            'city' => ['required'],
            'barangay' => ['required'],
            'emailAddress' => ['required', 'email', 'max:255'],
            'contactNumber' => ['required', 'max:255'],
            'organization' => ['required', 'max:255'],
        ];
    }

    public function attributes()
    {
        return [
            'firstName' => 'First Name',
            'middleName' => 'Middle Name',
            'lastName' => 'Last Name',
            'suffix' => 'Suffix',
            'houseNumber' => 'House No.',
            'streetName' => 'Street Name',
            'region' => 'Region',
            'province' => 'Province',
            'barangay' => 'Barangay',
            'emailAddress' => 'E-Mail Address',
            'contactNumber' => 'Contact Number',
            'contactNumber' => 'Contact Number',
            'organization' => 'Organization',
        ];
    }
}
