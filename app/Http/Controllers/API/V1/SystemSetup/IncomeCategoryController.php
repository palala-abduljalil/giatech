<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeCategoryRequest;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        return IncomeCategory::orderBy('id', 'desc')->get();
    }

    public function store(IncomeCategoryRequest $request)
    {
        IncomeCategory::create($request->validated());
        return response()->json([
            'message' => 'New Income added.'
        ]);
    }

    public function update(IncomeCategoryRequest $request, IncomeCategory $income_category)
    {
        $income_category->update($request->validated());
        return response()->json([
            'message' => 'Income Information has been updated.'
        ]);
    }

    public function destroy(IncomeCategory $income_category)
    {
        $income_category->delete();
        return response()->json([
            'message' => 'Income successfully removed.'
        ]);
    }
}
