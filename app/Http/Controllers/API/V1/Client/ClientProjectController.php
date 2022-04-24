<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Models\Client;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientProjectResource;

class ClientProjectController extends Controller
{
    public function index(Client $client)
    {
        return ClientProjectResource::collection(Project::with(['status', 'category'])->where('client_id', $client->id)->get());
    }
}
