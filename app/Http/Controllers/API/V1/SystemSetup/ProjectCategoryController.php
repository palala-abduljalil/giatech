<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Models\ProjectCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCategoryRequest;

class ProjectCategoryController extends Controller
{
    public function index()
    {
        return ProjectCategory::orderBy('id', 'desc')->get();
    }

    public function store(ProjectCategoryRequest $request)
    {
        ProjectCategory::create($request->validated());
        return response()->json([
            'message' => 'New School added.'
        ]);
    }

    public function update(ProjectCategoryRequest $request, ProjectCategory $project_category)
    {
        $project_category->update($request->validated());
        return response()->json([
            'message' => 'School Information has been updated.'
        ]);
    }

    public function destroy(ProjectCategory $project_category)
    {
        $project_category->delete();
        return response()->json([
            'message' => 'School successfully removed.'
        ]);
    }
}
