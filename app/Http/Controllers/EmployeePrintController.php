<?php

namespace App\Http\Controllers;

use App\Models\Employee;
class EmployeePrintController extends Controller
{
    public function index() 
    {
        $employees = Employee::with('position', 'department')->get();
        logActivity("Generated an Report of Employee List");
        return view('pages.report.employee.employee-print-list')->with('employees', $employees);
    }
    
    public function show($id) 
    {
        $employee = Employee::with('position', 'department', 'address')->find($id);
        $employee->profilePicture = $employee->getMedia('employee_profile_picture')->first()->getUrl();
        
        logActivity("Generated an Employee Report with a Employee Number " ."{$employee->employeeNumber}");
        return view('pages.report.employee.employee-print-details')->with('employee', $employee);
    }
}
