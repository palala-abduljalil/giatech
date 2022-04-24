<?php

namespace App\Services\Project;

use App\Models\Project;
use Barryvdh\Debugbar\Facades\Debugbar;

class StoreProjectService
{
    public function __construct(array $project)
    {
        Debugbar::info($project);

        $this->projectInfo = array(
            'title' => $project['title'],
            'description' => $project['description'],
            'totalContractPrice' => $project['totalContractPrice'],
            'startDate' => $project['startDate'],
            'endDate' => $project['endDate'],
            'client_id' => $project['client'],
            'category_id' => $project['category'],
            'status_id' => $project['status'],
            'created_by' => auth()->user()->employee_id,
        );
    }

    public function storeProject(): void
    {
        $this->project = Project::create($this->projectInfo);
    }
}
