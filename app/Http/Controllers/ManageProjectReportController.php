<?php

namespace App\Http\Controllers;

class ManageProjectReportController extends Controller
{
    public function index() 
    {
        return view('pages.report.project.index');
    }
}
