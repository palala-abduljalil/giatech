<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Models\Degree;
use App\Http\Controllers\Controller;
use App\Http\Requests\DegreeRequest;

class DegreeController extends Controller
{
    public function index()
    {
        return Degree::orderBy('id', 'desc')->get();
    }

    public function store(DegreeRequest $request)
    {
        Degree::create($request->validated());
        return response()->json([
            'message' => 'New Degree added.'
        ]);
    }

    public function update(DegreeRequest $request, Degree $degree)
    {
        $degree->update($request->validated());
        return response()->json([
            'message' => 'Degree Information has been updated.'
        ]);
    }

    public function destroy(Degree $degree)
    {
        $degree->delete();
        return response()->json([
            'message' => 'Degree successfully removed.'
        ]);
    }
}
