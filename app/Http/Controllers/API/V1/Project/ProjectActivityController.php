<?php

namespace App\Http\Controllers\API\V1\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectActivityRequest;
use App\Http\Resources\ProjectActivityResource;
use App\Models\Project;

class ProjectActivityController extends Controller
{
    public function index(Project $project)
    {
        return ProjectActivityResource::collection($project->activities()->orderBy('id', 'desc')->get());
    }

    public function store(ProjectActivityRequest $request, Project $project)
    {
        $project->activities()->create($request->validated());
        return response()->json([
            'message' => 'New Activity added.'
        ]);
    }

    public function show(Project $project, $id)
    {
        return new ProjectActivityResource($project->activities->firstWhere('id', $id));
    }

    public function update(ProjectActivityRequest $request, Project $project, $id)
    {
        $project->activities()->firstWhere('id', $id)->update($request->validated());
        return response()->json([
            'message' => 'Activity Information has been updated.'
        ]);
    }

    public function destroy(Project $project, $id)
    {
        $project->activities()->firstWhere('id', $id)->delete();
        return response()->json([
            'message' => 'Activity successfully removed.'
        ]);
    }
}
