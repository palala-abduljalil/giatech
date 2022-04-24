<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Models\School;
use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolRequest;

class SchoolController extends Controller
{
    public function index()
    {
        return School::orderBy('id', 'desc')->get();
    }

    public function store(SchoolRequest $request)
    {
        School::create($request->validated());
        return response()->json([
            'message' => 'New School added.'
        ]);
    }

    public function update(SchoolRequest $request, School $school)
    {
        $school->update($request->validated());
        return response()->json([
            'message' => 'School Information has been updated.'
        ]);
    }

    public function destroy(School $school)
    {
        $school->delete();
        return response()->json([
            'message' => 'School successfully removed.'
        ]);
    }
}
