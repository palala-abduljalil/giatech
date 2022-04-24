<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        return Position::orderBy('id', 'desc')->get();
    }

    public function store(PositionRequest $request)
    {
        Position::create($request->validated());
        return response()->json([
            'message' => 'New Position added.'
        ]);
    }

    public function update(PositionRequest $request, Position $position)
    {
        $position->update($request->validated());
        return response()->json([
            'message' => 'Position Information has been updated.'
        ]);
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return response()->json([
            'message' => 'Position successfully removed.'
        ]);
    }
}
