<?php

namespace App\Http\Controllers\API\V1\Finance\Expense;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseAttachmentResource;

class ExpenseAttachmentController extends Controller
{
    protected $collection = 'expense_attachments';

    public function index(Expense $expense)
    {
        return ExpenseAttachmentResource::collection($expense->getMedia($this->collection));
    }

    public function store(Request $request, Expense $expense)
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $expense->addMedia($file)->toMediaCollection($this->collection);
            }
            logActivity('Has added an expense');
        }
        return response()->json(['message' => 'Attachments has been added.']);
    }

    public function show(Expense $expense, $id)
    {
        logActivity('Has downloaded an expense');
        return $expense->getMedia($this->collection)->firstWhere('uuid', $id);
    }

    public function destroy(Expense $expense, $id)
    {
        logActivity('Has deleted an expense');
        $expense->getMedia($this->collection)->firstWhere('uuid', $id)->delete();
        return response()->noContent();
    }
}
