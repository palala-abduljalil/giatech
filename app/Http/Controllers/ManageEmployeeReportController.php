<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageEmployeeReportController extends Controller
{
    public function index()
    {
        return view('pages.report.employee.index');
    }
}
