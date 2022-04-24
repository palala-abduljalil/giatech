<?php

namespace App\Http\Controllers;

use App\Models\Expense;

class ExpensePrintController extends Controller
{
    public function index()
    {
        $expenses = Expense::with(['employee', 'category'])->get();
        logActivity('Has Generated a Expense List Report');
        return view('pages.report.expense.expense-print-list')->with('expenses', $expenses);
    }
}
