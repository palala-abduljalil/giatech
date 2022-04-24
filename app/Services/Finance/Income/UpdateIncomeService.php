<?php

namespace App\Services\Finance\Income;

use Carbon\Carbon;
use App\Models\Income;
use Barryvdh\Debugbar\Facades\Debugbar;

class UpdateIncomeService
{
    public function __construct(array $incomeInformation, Income $income)
    {
        Debugbar::info($incomeInformation);
        $this->income = $income;
        $this->incomeInfo = array(
            'project_id' => $incomeInformation['project'],
            'service' => $incomeInformation['service'],
            'amount' => $incomeInformation['amount'],
            'transactionDate' => Carbon::parse($incomeInformation['transactionDate'])->format('y-m-d'),
            'income_category_id' => $incomeInformation['category'],
        );
    }

    public function updateIncome(): void
    {
        $this->income->update($this->incomeInfo);
    }
}
