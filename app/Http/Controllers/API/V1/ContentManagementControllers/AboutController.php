<?php

namespace App\Http\Controllers\API\V1\ContentManagementControllers;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\AboutCompanyRequest;

class AboutController extends Controller
{
    public function show(Company $about)
    {
        return $about->first(['background', 'mission', 'vision']);
    }

    public function update(AboutCompanyRequest $request, Company $about)
    {
        $about->update($request->validated());
        return response()->json([
            'message' => 'Company Information has been updated.'
        ]);
    }
}
