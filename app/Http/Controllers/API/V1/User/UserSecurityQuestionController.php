<?php

namespace App\Http\Controllers\API\V1\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserSecurityQuestionResource;
use App\Http\Requests\UpdateUserSecurityQuestionRequest;

class UserSecurityQuestionController extends Controller
{
    public function index(User $user)
    {
        return UserSecurityQuestionResource::collection($user->securityQuestions);
    }

    public function update(UpdateUserSecurityQuestionRequest $request, User $user, $id)
    {
        logActivity('Has updated user security question with a employee number '.$user->employee->employeeNumber);
        $user->securityQuestions()->wherePivot('id', $id)->first()->pivot->update($request->validated());
        return response()->json([
            'message' => 'Security Question has been updated.'
        ]);
    }
}
