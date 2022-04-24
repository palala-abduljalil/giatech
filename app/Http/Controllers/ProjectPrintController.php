<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectPrintController extends Controller
{
    public function index() 
    {
        $projects = Project::with('status', 'category', 'client')->get();
        logActivity('Has Generated a Project List Report');
        return view('pages.report.project.project-print-list')->with('projects', $projects);
    }
    
    public function show($id) 
    {
        $project = Project::with('status', 'category', 'client')->find($id);
        logActivity('Has Generated a Project Activity List Report');
        return view('pages.report.project.project-activities-print-list')
            ->with('activities', $project->activities)
            ->with('project', $project->title);
    }
}
