<?php

namespace App\Services\Finance\Expense;

use Carbon\Carbon;
use App\Models\Expense;
use Barryvdh\Debugbar\Facades\Debugbar;

class StoreExpenseService
{
    public function __construct(array $expense)
    {
        $this->expenseInfo = array(
            'particular' => $expense['particular'],
            'amount' => $expense['amount'],
            'transactionDate' => Carbon::parse($expense['transactionDate'])->format('Y-m-d'),
            'employee_id' => $expense['employee'],
            'expense_category_id' => $expense['category'],
            'created_by' => auth()->user()->employee_id,
        );
    }

    public function storeExpense(): void
    {
        $this->expense = Expense::create($this->expenseInfo);
    }
}
