<?php

namespace App\Http\Controllers;

use App\Models\Income;


class ManageIncomeController extends Controller
{
    public function index()
    {
        return view('pages.finance.income.index');
    }

    public function create()
    {
        return view('pages.finance.income.create');
    }

    public function show(Income $income)
    {
        return view('pages.finance.income.show')->with('id', $income->id);
    }

    public function edit(Income $income)
    {
        return view('pages.finance.income.edit')->with('id', $income->id);
    }
}
