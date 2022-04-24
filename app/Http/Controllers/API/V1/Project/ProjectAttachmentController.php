<?php

namespace App\Http\Controllers\API\V1\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectAttachmentResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectAttachmentController extends Controller
{
    protected $collection = 'project_attachments';

    public function index(Project $project)
    {
        return ProjectAttachmentResource::collection($project->getMedia($this->collection));
    }

    public function store(Request $request, Project $project)
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $project->addMedia($file)->toMediaCollection($this->collection);
            }
            logActivity('Has added project attachment');
        }
        return response()->json(['message' => 'Attachments has been added.']);
    }

    public function show(Project $project, $id)
    {
        logActivity('Has downloaded project attachment');
        return $project->getMedia($this->collection)->firstWhere('uuid', $id);
    }

    public function destroy(Project $project, $id)
    {
        logActivity('Has deleted project attachment');
        $project->getMedia($this->collection)->firstWhere('uuid', $id)->delete();
        return response()->noContent();
    }
}
