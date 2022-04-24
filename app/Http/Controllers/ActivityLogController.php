<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\ActivityLogResource;

class ActivityLogController extends Controller
{
    public function index()
    {
        return view('pages.activity-logs.index', ['data' => ActivityLogResource::collection(Activity::with('causer.employee')->orderBy('created_at', 'desc')->get())]);
    }
}
