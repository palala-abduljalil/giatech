<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;

class ClientProjectPrintController extends Controller
{
    public function show($id) 
    {
        $projects = Project::with('status', 'category')->get()->where('client_id', $id);
        $client = Client::findOrFail($id);
        logActivity('Has Generated a Client\'s Project List Report');
        return view('pages.report.client.client-project-print-list')
            ->with('projects', $projects)
            ->with('client', $client->fullName);
    }
}
