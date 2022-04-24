<?php

namespace App\Http\Controllers\API\V1\SystemModule;

use App\Http\Controllers\Controller;
use App\Http\Resources\SystemModuleResource;
use App\Models\SystemModule;

class SystemModuleController extends Controller
{
    public function index()
    {
        return SystemModuleResource::collection(SystemModule::all());
    }
}
