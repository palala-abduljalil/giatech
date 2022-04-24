<?php

namespace App\Http\Controllers;

use App\Models\User;

class ManageUsersController extends Controller
{
    public function index()
    {
        return view('pages.user.index');
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function edit(User $user)
    {
        return view('pages.user.edit')->with('id', $user->id);;
    }

    public function show(User $user)
    {
        return view('pages.user.show')->with('id', $user->id);;
    }
}
