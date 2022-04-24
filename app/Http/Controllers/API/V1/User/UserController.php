<?php

namespace App\Http\Controllers\API\V1\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\User\StoreUserService;
use App\Services\User\UpdateUserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return UserResource::collection(User::with([
                'employee.profilePicture',
                'employee.position',
                'role',
                'status'
            ])->where('created_by', auth()->user()->employee_id)->get());
        }
        return UserResource::collection(User::with([
            'employee.profilePicture', 
            'employee.position',
            'role',
            'status',
            'createdBy.profilePicture',
            'createdBy.position'
        ])->get());
    }

    public function store(StoreUserRequest $request)
    {
        $user = new StoreUserService($request->validated());
        $user->storeUser();
        return response()->json(['message' => 'New Account has been registered.']);
    }

    public function show(User $user)
    {
        return new UserResource(User::with(['modules', 'employee.profilePicture', 'employee.department', 'employee.address', 'employee.position'])->find($user->id));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user = new UpdateUserService($request->validated(), $user);
        $user->updateUser();
        return response()->json(['message' => 'Account has been updated.']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }
}
