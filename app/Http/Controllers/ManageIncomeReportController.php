<?php

namespace App\Http\Controllers;

class ManageIncomeReportController extends Controller
{
    public function index()
    {
        return view('pages.report.income.index');   
    }
}
