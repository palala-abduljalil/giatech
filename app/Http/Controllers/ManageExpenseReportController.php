<?php

namespace App\Http\Controllers;

class ManageExpenseReportController extends Controller
{
    public function index()
    {
        return view('pages.report.expense.index');   
    }
}
