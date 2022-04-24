<?php

namespace App\Http\Controllers\API\V1\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeAttachmentResource;

class EmployeeAttachmentController extends Controller
{
    protected $collection = 'employee_attachments';

    public function index(Employee $employee)
    {
        return EmployeeAttachmentResource::collection($employee->getMedia($this->collection));
    }

    public function store(Request $request, Employee $employee)
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $employee->addMedia($file)->toMediaCollection($this->collection);
            }
            logActivity('Has added an attachment(s) with an employee number '. $employee->employeeNumber);
        }
        return response()->json(['message' => 'Attachments has been added.']);
    }

    public function show(Employee $employee, $id)
    {
        logActivity('Has downloaded an attachment with an employee number '. $employee->employeeNumber);
        return $employee->getMedia($this->collection)->firstWhere('uuid', $id);
    }

    public function destroy(Employee $employee, $id)
    {
        logActivity('Has deleted an attachment with an employee number '. $employee->employeeNumber);
        $employee->getMedia($this->collection)->firstWhere('uuid', $id)->delete();
        return response()->noContent();
    }
}
