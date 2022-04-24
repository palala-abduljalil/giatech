<?php

namespace App\Services\Finance\Income;

use Carbon\Carbon;
use App\Models\Income;
use Barryvdh\Debugbar\Facades\Debugbar;

class StoreIncomeService
{
    public function __construct(array $income)
    {
        Debugbar::info($income);

        $this->incomeInfo = array(
            'project_id' => $income['project'],
            'service' => $income['service'],
            'amount' => $income['amount'],
            'transactionDate' => Carbon::parse($income['transactionDate'])->format('y-m-d'),
            'income_category_id' => $income['category'],
            'created_by' => auth()->user()->employee_id,
        );
    }

    public function storeIncome(): void
    {
        $this->income = Income::create($this->incomeInfo);
    }
}
