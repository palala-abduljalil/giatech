<?php

namespace App\Http\Controllers;

use App\Models\Income;

class IncomePrintController extends Controller
{
    public function index()
    {
        $incomes = Income::with(['project', 'category'])->get();
        logActivity('Has Generated a Income List Report');
        return view('pages.report.income.income-print-list')->with('incomes', $incomes);
    }
}
