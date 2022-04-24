<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ManageProjectsController extends Controller
{
    public function index()
    {
        return view('pages.project.index');
    }

    public function create()
    {
        return view('pages.project.create');
    }

    public function show(Project $project)
    {
        return view('pages.project.show')->with('id', $project->id);
    }

    public function edit(Project $project)
    {
        return view('pages.project.edit')->with('id', $project->id);
    }
}
