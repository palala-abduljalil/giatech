<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutCompanyRequest extends FormRequest
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
            'background' => ['required', 'min:10', 'max:65535'],
            'mission' => ['required', 'min:10', 'max:500'],
            'vision' => ['required', 'min:10', 'max:500'],
        ];
    }

    public function attributes()
    {
        return [
            'background' => 'Background',
            'mission' => 'Mission',
            'vision' => 'Vision',
        ];
    }
}
