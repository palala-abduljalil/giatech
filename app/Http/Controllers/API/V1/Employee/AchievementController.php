<?php

namespace App\Http\Controllers\API\V1\Employee;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\AchievementRequest;
use App\Http\Resources\AchievementResource;

class AchievementController extends Controller
{
    public function index(Employee $employee)
    {
        return AchievementResource::collection($employee->achievements()->orderBy('id', 'desc')->get());
    }

    public function show(Employee $employee, $id)
    {
        return new AchievementResource($employee->achievements->firstWhere('id', $id));
    }

    public function store(AchievementRequest $request, Employee $employee)
    {
        $employee->achievements()->create($request->validated());
        return response()->json([
            'message' => 'New Achievement added.'
        ]);
    }

    public function update(AchievementRequest $request, Employee $employee, $id)
    {
        $employee->achievements()->firstWhere('id', $id)->update($request->validated());
        return response()->json([
            'message' => 'Achievement Information has been updated.'
        ]);
    }

    public function destroy(Employee $employee, $id)
    {
        $employee->achievements()->firstWhere('id', $id)->delete();
        return response()->json([
            'message' => 'Achievement successfully removed.'
        ]);
    }
}
