<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Models\EmployeeStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStatusRequest;

class EmployeeStatusController extends Controller
{
    public function index()
    {
        return EmployeeStatus::orderBy('id', 'desc')->get();
    }

    public function store(EmployeeStatusRequest $request)
    {
        EmployeeStatus::create($request->validated());
        return response()->json([
            'message' => 'New Employee Status added.'
        ]);
    }

    public function update(EmployeeStatusRequest $request, EmployeeStatus $employee_status)
    {
        $employee_status->update($request->validated());
        return response()->json([
            'message' => 'Employee Status Information has been updated.'
        ]);
    }

    public function destroy(EmployeeStatus $employee_status)
    {
        $employee_status->delete();
        return response()->json([
            'message' => 'Employee Status successfully removed.'
        ]);
    }
}
