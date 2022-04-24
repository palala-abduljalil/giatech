<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseTransportationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'startPoint' => ['required', 'max:255'],
            'endPoint' => ['required', 'max:255'],
            'transactionDate' => ['required', 'date'],
            'purpose' => ['required', 'max:500'],
            'employee' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'startPoint' => 'Start Point',
            'endPoint' => 'End Point',
            'transactionDate' => 'Transportation Date',
            'purpose' => 'Purpose',
            'employee' => 'Handled By'
        ];
    }
}
