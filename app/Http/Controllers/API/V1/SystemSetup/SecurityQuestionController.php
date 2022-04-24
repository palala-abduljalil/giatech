<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Models\SecurityQuestion;
use App\Http\Controllers\Controller;
use App\Http\Requests\SecurityQuestionRequest;

class SecurityQuestionController extends Controller
{
    public function index()
    {
        return SecurityQuestion::orderBy('id', 'desc')->get();
    }

    public function store(SecurityQuestionRequest $request)
    {
        SecurityQuestion::create($request->validated());
        return response()->json([
            'message' => 'New Security Question added.'
        ]);
    }

    public function update(SecurityQuestionRequest $request, SecurityQuestion $security_question)
    {
        $security_question->update($request->validated());
        return response()->json([
            'message' => 'Security Question Information has been updated.'
        ]);
    }

    public function destroy(SecurityQuestion $security_question)
    {
        $security_question->delete();
        return response()->json([
            'message' => 'Security Question successfully removed.'
        ]);
    }
}
