<?php

namespace App\Services\Finance\Expense;

use Carbon\Carbon;
use App\Models\Expense;
use Barryvdh\Debugbar\Facades\Debugbar;

class UpdateExpenseService
{
    public function __construct(array $expenseInformation, Expense $expense)
    {
        Debugbar::info($expenseInformation);
        $this->expense = $expense;
        $this->expenseInfo = array(
            'particular' => $expenseInformation['particular'],
            'amount' => $expenseInformation['amount'],
            'transactionDate' => Carbon::parse($expenseInformation['transactionDate'])->format('y-m-d'),
            'employee_id' => $expenseInformation['employee'],
            'expense_category_id' => $expenseInformation['category'],
        );
    }

    public function updateExpense(): void
    {
        $this->expense->update($this->expenseInfo);
    }
}
