<?php

namespace App\Http\Requests;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'streetName' => ['required', 'max:500'],
            'region' => ['required'],
            'province' => ['required'],
            'city' => ['required'],
            'barangay' => ['required'],
            'businessEmail' => ['required', 'email', 'unique:employee_email_address,businessEmail', 'max:255'],
            'alternateEmail' => ['email', 'different:businessEmail', 'max:255'],
            'contactNumber' => ['required', 'max:255'],
            'position' => ['required'],
            'department' => ['required'],
            'employeeStatus' => ['required'],
            'degree' => ['required'],
            'school' => ['required'],
            'yearGraduated' => ['required', 'numeric'],
            'image' => ['mimes:jpeg,jpg,png', 'max:2048'],
            'achievements.*.description' => ['required', 'max:500'],
            'skills.*.description' => ['required', 'max:500'],
            'files.*' => ['mimes:jpg,jpeg,png,doc,docx,xls,xlsx,pdf,txt', 'max:2048']
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
            'businessEmail' => 'Business E-Mail',
            'alternateEmail' => 'Alternate E-Mail',
            'contactNumber' => 'Contact Number',
            'position' => 'Position',
            'department' => 'Department',
            'employeeStatus' => 'Status',
            'degree' => 'Degree',
            'school' => 'School',
            'yearGraduated' => 'Year Graduated',
            'image' => 'Image',
            'achievements.*.description' => 'Achievements Description',
            'skills.*.description' => 'Skills Description',
            'files' => 'File'
        ];
    }
}
