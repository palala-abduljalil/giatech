<?php

namespace App\Services\Finance\ExpenseTransportation;

use Carbon\Carbon;
use App\Models\ExpenseTransportation;

class StoreExpenseTransportationService
{
    public function __construct(array $expense)
    {
        $this->expenseInfo = array(
            'startPoint' => $expense['startPoint'],
            'endPoint' => $expense['endPoint'],
            'transactionDate' => Carbon::parse($expense['transactionDate'])->format('y-m-d'),
            'purpose' => $expense['purpose'],
            'employee_id' => $expense['employee'],
            'created_by' => auth()->user()->employee_id,
        );
    }

    public function storeExpense(): void
    {
        $this->expense = ExpenseTransportation::create($this->expenseInfo);
    }
}
