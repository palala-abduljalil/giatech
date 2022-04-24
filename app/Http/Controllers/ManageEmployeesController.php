<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class ManageEmployeesController extends Controller
{
    public function index()
    {
        return view('pages.employee.index');
    }

    public function create()
    {
        return view('pages.employee.create');
    }

    public function show(Employee $employee)
    {
        return view('pages.employee.show')->with('id', $employee->id);
    }

    public function edit(Employee $employee)
    {
        return view('pages.employee.edit')->with('id', $employee->id);
    }
}
