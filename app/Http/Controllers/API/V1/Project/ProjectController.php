<?php

namespace App\Http\Controllers\API\V1\Project;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\Project\StoreProjectService;
use App\Services\Project\UpdateProjectService;

class ProjectController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return ProjectResource::collection(Project::with([
                'status',
                'category',
                'client',
            ])->get());
        }
        return ProjectResource::collection(Project::with([
            'status',
            'category',
            'client',
            'client.profilePicture',
            'client.organization',
            'createdBy.profilePicture',
            'createdBy.position'
        ])->get());
    }

    public function store(ProjectRequest $request)
    {
        $project = new StoreProjectService($request->validated());
        $project->storeProject();
        return response()->json(['message' => 'Project has been created.']);
    }

    public function show(Project $project)
    {
        return new ProjectResource(Project::with([
            'status',
            'category',
            'client',
            'activities'
        ])->find($project->id));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $updatedProject = new UpdateProjectService($request->validated(), $project);
        $updatedProject->updateProject();
        return response()->json([
            'message' => 'Project has been updated'
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->noContent();
    }
}
