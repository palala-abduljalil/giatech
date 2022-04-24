<?php

namespace App\Http\Controllers\API\V1\Employee;

use App\Models\Employee;
use App\Http\Requests\SkillRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\SkillResource;

class SkillController extends Controller
{
    public function index(Employee $employee)
    {
        return SkillResource::collection($employee->skills()->orderBy('id', 'desc')->get());
    }

    public function show(Employee $employee, $id)
    {
        return new SkillResource($employee->skills()->firstWhere('id', $id));
    }

    public function store(SkillRequest $request, Employee $employee)
    {
        $employee->skills()->create($request->validated());
        return response()->json([
            'message' => 'New Skill added.'
        ]);
    }

    public function update(SkillRequest $request, Employee $employee, $id)
    {
        $employee->skills()->firstWhere('id', $id)->update($request->validated());
        return response()->json([
            'message' => 'Skill Information has been updated.'
        ]);
    }

    public function destroy(Employee $employee, $id)
    {
        $employee->skills()->firstWhere('id', $id)->delete();
        return response()->json([
            'message' => 'Skill successfully removed.'
        ]);
    }
}
