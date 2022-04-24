<?php

namespace App\Http\Controllers\API\V1\SystemSetup;

use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseCategoryRequest;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        return ExpenseCategory::orderBy('id', 'desc')->get();
    }

    public function store(ExpenseCategoryRequest $request)
    {
        ExpenseCategory::create($request->validated());
        return response()->json([
            'message' => 'New Expense added.'
        ]);
    }

    public function update(ExpenseCategoryRequest $request, ExpenseCategory $expense_category)
    {
        $expense_category->update($request->validated());
        return response()->json([
            'message' => 'Expense Information has been updated.'
        ]);
    }

    public function destroy(ExpenseCategory $expense_category)
    {
        $expense_category->delete();
        return response()->json([
            'message' => 'Expense successfully removed.'
        ]);
    }
}
