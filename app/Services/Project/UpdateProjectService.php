<?php

namespace App\Services\Project;

use App\Models\Project;
use Barryvdh\Debugbar\Facades\Debugbar;

class UpdateProjectService
{
    public function __construct(array $projectInformation, Project $project)
    {
        Debugbar::info($projectInformation);
        $this->project = $project;

        $this->projectInformation = array(
            'title' => $projectInformation['title'],
            'description' => $projectInformation['description'],
            'totalContractPrice' => $projectInformation['totalContractPrice'],
            'startDate' => $projectInformation['startDate'],
            'endDate' => $projectInformation['endDate'],
            'client_id' => $projectInformation['client'],
            'category_id' => $projectInformation['category'],
            'status_id' => $projectInformation['status'],
        );
    }

    public function updateProject(): void
    {
        $this->project->update($this->projectInformation);
    }
}
