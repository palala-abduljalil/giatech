<?php

namespace App\Http\Controllers\API\V1\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserActivationController extends Controller
{
    public function store(Request $request)
    {
        // Activate
        $user = User::find($request->id);
        $user->update(['isActivated' => 1]);
        logActivity('Has activated user account with an employee number ' . $user->employee->employeeNumber);
        return response()->json(['message' => 'Account has been activated.']);
    }

    public function update(Request $request, User $user_activation)
    {
        // Deactivate
        $user_activation->update(['isActivated' => 0]);
        logActivity('Has deactivated user account with an employee number ' . $user_activation->employee->employeeNumber);
        return response()->json(['message' => 'Account has been deactivated.']);
    }
}
