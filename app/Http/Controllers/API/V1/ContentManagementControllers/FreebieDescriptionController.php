<?php

namespace App\Http\Controllers\API\V1\ContentManagementControllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class FreebieDescriptionController extends Controller
{
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'freebieDescription' => 'required|min:10|max:500',
        ]);
        $company->update($validated);
        return response()->json([
            'message' => 'Description has been updated.'
        ]);
    }
}
