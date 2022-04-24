<?php

namespace App\Services\Finance\ExpenseTransportation;

use Carbon\Carbon;
use App\Models\ExpenseTransportation;

class UpdateExpenseTransportationService
{
    public function __construct(array $expenseInformation, ExpenseTransportation $expense)
    {
        $this->expense = $expense;
        $this->expenseInfo = array(
            'startPoint' => $expenseInformation['startPoint'],
            'endPoint' => $expenseInformation['endPoint'],
            'transactionDate' => Carbon::parse($expenseInformation['transactionDate'])->format('y-m-d'),
            'purpose' => $expenseInformation['purpose'],
            'employee_id' => $expenseInformation['employee'],
        );
    }

    public function updateExpense(): void
    {
        $this->expense->update($this->expenseInfo);
    }
}
