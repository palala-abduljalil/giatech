<?php

namespace App\Http\Controllers;

class ManageClientReportController extends Controller
{
    public function index()
    {
        return view('pages.report.client.index');
    }
}
