<?php

namespace App\Http\Controllers\API\V1\ContentManagementControllers;

use App\Models\StakeHolder;

use App\Http\Controllers\Controller;
use App\Http\Resources\StakeholderResource;
use App\Http\Requests\StoreStakeholderRequest;
use App\Http\Requests\UpdateStakeholderRequest;

class StakeholderController extends Controller
{
    public function index()
    {
        return StakeholderResource::collection(StakeHolder::with([
            'employee',
            'employee.position',
            'employee.profilePicture'
        ])->where('company_id', 1)->latest('id')->paginate(3));
    }

    public function store(StoreStakeholderRequest $request)
    {
        StakeHolder::create([
            'employee_id' => $request->employee,
            'linkedInLink' => $request->link,
            'company_id' => $request->company_id,
        ]);

        return response()->json([
            'message' => 'New Stakeholder added.'
        ]);
    }

    public function update(UpdateStakeholderRequest $request, StakeHolder $stakeholder)
    {
        $stakeholder->update([
            'employee_id' => $request->employee,
            'linkedInLink' => $request->link,
            'company_id' => $request->company_id,
        ]);

        return response()->json([
            'message' => 'Stakeholder Information has been updated.'
        ]);
    }

    public function destroy(StakeHolder $stakeholder)
    {
        $stakeholder->delete();
        return response()->json([
            'message' => 'Stakeholder successfully removed.'
        ]);
    }
}
