<?php

namespace App\Http\Controllers\API\V1\Finance\Income;

use App\Models\Income;
use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeRequest;
use App\Http\Resources\IncomeResource;
use App\Services\Finance\Income\StoreIncomeService;
use App\Services\Finance\Income\UpdateIncomeService;

class IncomeController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return IncomeResource::collection(Income::with([
                'project',
                'category'
            ])->where('created_by', auth()->user()->employee_id)->get());
        }
        return IncomeResource::collection(Income::with([
            'project',
            'category',
            'createdBy.profilePicture',
            'createdBy.position'
        ])->get());
    }

    public function store(IncomeRequest $request)
    {
        $income = new StoreIncomeService($request->validated());
        $income->storeIncome();
        return response()->json(['message' => 'Income has been created.']);
    }

    public function show(Income $income)
    {
        return new IncomeResource(Income::with(['project', 'category'])->find($income->id));
    }

    public function update(IncomeRequest $request, Income $income)
    {
        $updatedIncome = new UpdateIncomeService($request->validated(), $income);
        $updatedIncome->updateIncome();
        return response()->json([
            'message' => 'Income has been updated'
        ]);
    }

    public function destroy(Income $income)
    {
        $income->delete();
        return response()->noContent();
    }
}
