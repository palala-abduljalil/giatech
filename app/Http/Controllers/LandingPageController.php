<?php

namespace App\Http\Controllers;

use App\Mail\ContactMe;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\CompanyResource;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('landing-page')
            ->with('data', new CompanyResource(Company::with([
                'stakeholders.employee',
                'stakeholders.employee.position',
                'stakeholders.employee.profilePicture',
                'stakeholders',
                'socialMediaAccounts',
                'services',
                'services.coverImage',
                'freebies',
                'freebies.coverImage',
            ])->first()));
    }

    public function store(Request $request)
    {
        $data = request(['name', 'email', 'subject', 'message']);
        Mail::to('palala.giatech@gmail.com')->send(new ContactMe($data));
        return $data;
    }
}
