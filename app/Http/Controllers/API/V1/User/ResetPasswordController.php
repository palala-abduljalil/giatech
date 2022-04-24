<?php

namespace App\Http\Controllers\API\V1\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function update(ResetPasswordRequest $request, User $user)
    {
        $user->update(['password' => Hash::make($request->password)]);
        logActivity('Has updated user password with an employee number ' . $user->employee->employeeNumber);
        return response()->json(['message' => 'Password has been resseted.']);
    }
}
