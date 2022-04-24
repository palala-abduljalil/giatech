<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    public function index()
    {
        return Department::orderBy('id', 'desc')->get();
    }

    public function store(DepartmentRequest $request)
    {
        Department::create($request->validated());
        return response()->json([
            'message' => 'New Department added.'
        ]);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());
        return response()->json([
            'message' => 'Department Information has been updated.'
        ]);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json([
            'message' => 'Department successfully removed.'
        ]);
    }
}
