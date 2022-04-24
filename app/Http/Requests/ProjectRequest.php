<?php

namespace App\Http\Requests;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title' => ['required', 'max:500'],
            'description' => ['required', 'max:5000'],
            'totalContractPrice' => ['required', 'regex:/^[0-9]+(\.[0-9]{1,2})?$/'],
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date'],
            'client' => ['required'],
            'category' => ['required'],
            'status' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'totalContractPrice' => 'Total Contract Price',
            'startDate' => 'Duration',
            'endDate' => 'End Date',
            'client' => 'Client',
            'category' => 'Category',
            'status' => 'Status',
        ];
    }
}
