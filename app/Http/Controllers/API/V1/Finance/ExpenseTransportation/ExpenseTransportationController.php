<?php

namespace App\Http\Controllers\API\V1\Finance\ExpenseTransportation;

use App\Http\Controllers\Controller;
use App\Models\ExpenseTransportation;
use App\Http\Requests\ExpenseTransportationRequest;
use App\Http\Resources\ExpenseTransportationResource;
use App\Services\Finance\ExpenseTransportation\StoreExpenseTransportationService;
use App\Services\Finance\ExpenseTransportation\UpdateExpenseTransportationService;

class ExpenseTransportationController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return ExpenseTransportationResource::collection(ExpenseTransportation::with([
                'employee.profilePicture',
                'employee.position'
            ])->where('created_by', auth()->user()->employee_id)->get());
        }
        return ExpenseTransportationResource::collection(ExpenseTransportation::with([
            'employee.profilePicture',
            'employee.position',
            'createdBy.profilePicture',
            'createdBy.position'
        ])->get());
    }

    public function store(ExpenseTransportationRequest $request)
    {
        $expense = new StoreExpenseTransportationService($request->validated());
        $expense->storeExpense();
        return response()->json(['message' => 'Expense has been created.']);
    }

    public function show(ExpenseTransportation $expenseTransportation)
    {
        return new ExpenseTransportationResource(ExpenseTransportation::with(['employee'])->find($expenseTransportation->id));
    }

    public function update(ExpenseTransportationRequest $request, ExpenseTransportation $expenseTransportation)
    {
        $updatedExpense = new UpdateExpenseTransportationService($request->validated(), $expenseTransportation);
        $updatedExpense->updateExpense();
        return response()->json([
            'message' => 'Expense has been updated'
        ]);
    }

    public function destroy(ExpenseTransportation $expenseTransportation)
    {
        $expenseTransportation->delete();
        return response()->noContent();
    }
}
