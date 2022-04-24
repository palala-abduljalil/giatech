<?php

namespace App\Services\User;

class StoreUserSecurityQuestionService
{
    public function __construct(array $request)
    {
        $this->securityQuestions = $request;
    }

    public function store(): void
    {
        $this->storeSecurityQuestions($this->securityQuestions);
    }

    private function storeSecurityQuestions(array $securityQuestions) : void
    {
        $sync_data = [];
        foreach($securityQuestions as $question) {
            $sync_data[$question["question"]] = ['answer' => $question["answer"]];
        }
        auth()->user()->securityQuestions()->sync($sync_data);
    }
}
