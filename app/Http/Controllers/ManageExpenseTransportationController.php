<?php

namespace App\Http\Controllers;

use App\Models\ExpenseTransportation;
use App\Http\Resources\ExpenseTransportationResource;

class ManageExpenseTransportationController extends Controller
{
    public function index()
    {
        return view('pages.finance.expense-transportation.index');
    }

    public function create()
    {
        return view('pages.finance.expense-transportation.create');
    }

    public function show(ExpenseTransportation $expenses_transportation)
    {
        return view('pages.finance.expense-transportation.show')
            ->with('data', new ExpenseTransportationResource(ExpenseTransportation::with(['employee'])->find($expenses_transportation->id)));
    }

    public function edit(ExpenseTransportation $expenses_transportation)
    {
        return view('pages.finance.expense-transportation.edit')->with('id', $expenses_transportation->id);
    }
}
