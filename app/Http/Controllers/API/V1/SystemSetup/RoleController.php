<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return RoleResource::collection(Role::orderBy('id', 'desc')->get());
    }

    public function store(RoleRequest $request)
    {
        Role::create($request->validated());
        return response()->json([
            'message' => 'New Position added.'
        ]);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return response()->json([
            'message' => 'Role Information has been updated.'
        ]);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json([
            'message' => 'Role successfully removed.'
        ]);
    }
}
