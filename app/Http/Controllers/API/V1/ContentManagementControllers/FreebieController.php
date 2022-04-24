<?php

namespace App\Http\Controllers\API\V1\ContentManagementControllers;

use App\Models\Company;

use App\Models\Freebie;
use App\Http\Controllers\Controller;
use App\Http\Requests\FreebieRequest;

use App\Http\Resources\FreebieResource;
use App\Services\Content\Freebie\StoreFreebieService;
use App\Services\Content\Freebie\UpdateFreebieService;

class FreebieController extends Controller
{
    public function index()
    {
        $freebie = FreebieResource::collection(Freebie::with([
            'coverImage',
            'createdBy.profilePicture',
            'createdBy.position'
        ])->orderBy('id', 'desc')->get());

        if (!auth()->user()->isAdmin()) {
            $freebie = FreebieResource::collection(Freebie::with([
                'coverImage'
            ])->orderBy('id', 'desc')->where('created_by', auth()->user()->employee_id)->get());
        }

        $freebieDescription = Company::first()->freebieDescription;
        return response()->json([
            'freebies' => $freebie,
            'freebieDescription' => $freebieDescription
        ]);
    }

    public function store(FreebieRequest $request)
    {
        $freebie = new StoreFreebieService($request->validated());
        $freebie->store();
        return response()->json([
            'message' => 'New Freebie added.'
        ]);
    }

    public function update(FreebieRequest $request, Freebie $freebie)
    {
        $updatedFreebie = new UpdateFreebieService($request->validated(), $freebie);
        $updatedFreebie->update();
        return response()->json([
            'message' => 'Freebie Information has been updated.'
        ]);
    }

    public function destroy(Freebie $freebie)
    {
        $freebie->delete();
        return response()->json([
            'message' => 'Freebie successfully removed.'
        ]);
    }
}
