<?php

namespace App\Services\User;

use App\Models\User;

class UpdateUserService
{
    public function __construct(array $userInformation, User $user)
    {
        $this->userInfo = array(
            'username' => $userInformation['employee']
        );

        $this->user = $user;

        if (array_key_exists('modules', $userInformation)) {
            $this->modules = $userInformation['modules'];
        }
    }

    public function updateUser(): void
    {
        $this->user->update($this->userInfo);
        if (isset($this->modules)) {
            $this->updateModules($this->modules);
        }
    }

    private function updateModules(array $modules): void
    {
        $this->user->modules()->sync($modules);
        logActivity('Has updated user\'s permissions with an employee number ' . 
            $this->user->employee->employeeNumber);
    }
}
