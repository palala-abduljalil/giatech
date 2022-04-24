<?php

namespace App\Http\Controllers;

use App\Models\Expense;

class ManageExpenseController extends Controller
{
    public function index()
    {
        return view('pages.finance.expense.index');
    }

    public function create()
    {
        return view('pages.finance.expense.create');
    }

    public function show(Expense $expense)
    {
        return view('pages.finance.expense.show')->with('id', $expense->id);
    }

    public function edit(Expense $expense)
    {
        return view('pages.finance.expense.edit')->with('id', $expense->id);
    }
}
