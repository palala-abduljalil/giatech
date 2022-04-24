<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangeUserPasswordRequest;

class ChangeUserPasswordController extends Controller
{
    public function update(ChangeUserPasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->newPassword)]);
        logActivity('Has updated user password with an employee number ' . auth()->user()->employee->employeeNumber);
        return response()->json(['message' => 'Account password has been updated.']);
    }
}
