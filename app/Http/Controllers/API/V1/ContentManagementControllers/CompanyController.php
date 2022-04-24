<?php

namespace App\Http\Controllers\API\V1\ContentManagementControllers;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Services\Content\ContactDetails\UpdateContactDetailsService;

class CompanyController extends Controller
{
    public function index()
    {
        return new CompanyResource(Company::with('socialMediaAccounts')->first());
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $updateCompany = new UpdateContactDetailsService($request->only([
            'emailAddress',
            'websiteAddress',
            'landlineNumber',
            'mobileNumber',
            'socialMediaAccounts'
        ]), $company);
        $updateCompany->update();
        return response()->json([
            'message' => 'Company Information has been updated.'
        ]);
    }
}
