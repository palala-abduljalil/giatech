<?php

namespace App\Http\Controllers\API\V1\Finance\Expense;

use App\Models\Expense;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Services\Finance\Expense\StoreExpenseService;
use App\Services\Finance\Expense\UpdateExpenseService;

class ExpenseController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return ExpenseResource::collection(Expense::with([
                'employee.profilePicture',
                'employee.position',
                'category'
            ])->where('created_by', auth()->user()->employee_id)->get());
        }
        return ExpenseResource::collection(Expense::with([
            'employee.profilePicture',
            'employee.position',
            'category',
            'createdBy.profilePicture',
            'createdBy.position'
        ])->get());
    }

    public function store(ExpenseRequest $request)
    {
        $expense = new StoreExpenseService($request->validated());
        $expense->storeExpense();
        return response()->json(['message' => 'Expense has been created.']);
    }

    public function show(Expense $expense)
    {
        return new ExpenseResource(Expense::with(['employee', 'category'])->find($expense->id));
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        $updatedExpense = new UpdateExpenseService($request->validated(), $expense);
        $updatedExpense->updateExpense();
        return response()->json([
            'message' => 'Expense has been updated'
        ]);
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->noContent();
    }
}
