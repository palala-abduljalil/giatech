<?php

namespace App\Http\Controllers\API\V1\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateEmployeeAvatarController extends Controller
{
    public function update(Request $request, Employee $employee)
    {
        if ($request->hasFile('image')) {
            $employee->addMedia($request->file('image'))->toMediaCollection('employee_profile_picture');
            logActivity('Has updated employee profile picture with an employee number ' . $employee->employeeNumber);
            return response()->json(['message' => 'Employee Profile Picture has been updated']);
        }
        return response()->json(['message' => '']);
    }
}
