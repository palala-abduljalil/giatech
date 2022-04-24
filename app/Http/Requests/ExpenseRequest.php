<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'particular' => ['required', 'max:500'],
            'amount' => ['required', 'regex:/^[0-9]+(\.[0-9]{1,2})?$/'],
            'transactionDate' => ['required', 'date'],
            'employee' => ['required'],
            'category' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'particular' => 'Particular',
            'amount' => 'Amounts',
            'transactionDate' => 'Transaction Date',
            'employee' => 'Handled By',
            'category' => 'Category'
        ];
    }
}
