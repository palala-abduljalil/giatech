<?php

namespace App\Http\Controllers;

use App\Models\SecurityQuestion;
use App\Http\Requests\UserSecurityQuestionRequest;
use App\Services\User\StoreUserSecurityQuestionService;

class UserSecurityQuestionController extends Controller
{
    public function index()
    {
        return view('renew')->with(['data' => SecurityQuestion::all()]);
    }

    public function store(StoreUserSecurityQuestionRequest $request)
    {
        $user = new StoreUserSecurityQuestionService($request->validated());
        $user->store();
        return response()->noContent();
    }
}
