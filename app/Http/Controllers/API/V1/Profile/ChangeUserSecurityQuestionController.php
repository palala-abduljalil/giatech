<?php

namespace App\Http\Controllers\API\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeUserSecurityQuestionRequest;

class ChangeUserSecurityQuestionController extends Controller
{
    public function update(ChangeUserSecurityQuestionRequest $request)
    {
        auth()->user()->securityQuestions()->wherePivot('id', $request->id)->first()->pivot->update([
            'security_question_id' => $request->security_question,
            'answer' => $request->answer
        ]);
        logActivity('Has updated user security question with an employee numnber ' . auth()->user()->employee->employeeNumber);
        return response()->json([
            'message' => 'Security Question has been updated.'
        ]);
    }
}
