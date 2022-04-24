<?php

namespace App\Http\Controllers\API\V1\ContentManagementControllers;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\Employee\StoreEmployeeService;
use App\Services\Employee\UpdateEmployeeService;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return EmployeeResource::collection(Employee::with([
                'position',
                'department',
                'profilePicture',
                ])->where('created_by', auth()->user()->employee_id)->get());
        }
        
        return EmployeeResource::collection(Employee::with([
            'position',
            'department',
            'profilePicture',
            'createdBy.profilePicture',
            'createdBy.position'
        ])->get());
    }

    public function show(Employee $employee)
    {
        return new EmployeeResource(Employee::with([
            'address',
            'contactNumber',
            'emailAddress',
            'position',
            'department',
            'status',
            'school',
            'degree',
            'profilePicture'
        ])->find($employee->id));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = new StoreEmployeeService($request->validated());
        $employee->storeEmployee();
        return response()->json(['message' => 'Employee has been registered.']);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $updatedEmployee = new UpdateEmployeeService($request->validated(), $employee);
        $updatedEmployee->updateEmployee();
        return response()->json([
            'employee' => new EmployeeResource(Employee::with([
                'address',
                'position',
                'department',
                'media'
            ])->find($employee->id)),
            'message' => 'Employee has been updated'
        ]);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->noContent();
    }
}
