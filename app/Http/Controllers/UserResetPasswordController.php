<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserResetPasswordRequest;

class UserResetPasswordController extends Controller
{
    public function index()
    {
        return view('user-reset-password');
    }

    public function update(UserResetPasswordRequest $request)
    {
        auth()->user()->update([
            'password' => Hash::make($request->password),
            'isRenewed' => 1,
        ]);
        return response()->noContent();
    }
}
