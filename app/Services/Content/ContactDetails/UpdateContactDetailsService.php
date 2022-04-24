<?php

namespace App\Services\Content\ContactDetails;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class UpdateContactDetailsService 
{
    public function __construct(array $request, Company $company)
    {
        $this->info = array (
            'emailAddress' => $request['emailAddress'],
            'websiteAddress' => $request['websiteAddress'],
            'landlineNumber' => $request['landlineNumber'],
            'mobileNumber' => $request['mobileNumber'],
        );
        $this->company = $company;
        if (array_key_exists('socialMediaAccounts', $request)) {
            $this->socialMediaAccounts = $request['socialMediaAccounts'];
        }
    }

    public function update(): void {
        $this->company->update($this->info);
        if (isset($this->socialMediaAccounts)) {
            $this->updateSocialMediaAccounts($this->socialMediaAccounts);
        }
    }

    private function updateSocialMediaAccounts(array $socialMediaAccounts): void {
        $caseString = 'case id';
        $ids = '';
        foreach ($socialMediaAccounts as $value) {
            $id = $value['id'];
            $displayIndex = $value['link'];
            $caseString .= " when $id then \"$displayIndex\"";
            $ids .= " $id,";
        }
        $ids = trim($ids, ',');
        DB::update("update company_social_media set link = $caseString end where id in ($ids)");
        
        logActivity('Has Updated Social Link in Content Management');
    }
}