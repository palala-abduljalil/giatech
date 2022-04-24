<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class StoreUserService
{
    public function __construct(array $user)
    {
        $employee = Employee::where('employeeNumber', $user['employee'])->first();
        $this->userInfo = array (
            'username' => $user['employee'],
            'password' => Hash::make($user['employee']),
            'email' => $employee->emailAddress->businessEmail,
            'created_by' => auth()->user()->employee_id,
            'employee_id' => $employee->id,
        );

        if (array_key_exists('modules', $user)) {
            $this->modules = $user['modules'];
        }
    }

    public function storeUser(): void {
        $this->user = User::create($this->userInfo);
        if (isset($this->modules)) {
            $this->storeModules($this->modules);
        }
    }

    private function storeModules(array $modules): void {
        $this->user->modules()->attach($modules);
    }
}
