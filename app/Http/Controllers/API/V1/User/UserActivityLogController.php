<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserActivityLogResource;
use App\Models\User;

class UserActivityLogController extends Controller
{
    public function index(User $user)
    {
        return UserActivityLogResource::collection($user->actions);
    }
}
