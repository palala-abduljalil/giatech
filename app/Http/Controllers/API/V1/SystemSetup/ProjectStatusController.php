<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Models\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStatusRequest;

class ProjectStatusController extends Controller
{
    public function index()
    {
        return ProjectStatus::orderBy('id', 'desc')->get();
    }

    public function store(ProjectStatusRequest $request)
    {
        ProjectStatus::create($request->validated());
        return response()->json([
            'message' => 'New School added.'
        ]);
    }

    public function update(ProjectStatusRequest $request, ProjectStatus $project_status)
    {
        $project_status->update($request->validated());
        return response()->json([
            'message' => 'School Information has been updated.'
        ]);
    }

    public function destroy(ProjectStatus $project_status)
    {
        $project_status->delete();
        return response()->json([
            'message' => 'School successfully removed.'
        ]);
    }
}
