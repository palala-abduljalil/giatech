<?php

namespace App\Http\Controllers;
use App\Models\Client;

class ClientPrintController extends Controller
{
    public function index() 
    {
        $clients = Client::with(['address','contactNumber', 'emailAddress', 'organization'])->get();
        logActivity('Generated a Client List Report');
        return view('pages.report.client.client-print-list')->with('clients', $clients);
    }
    
    public function show($id) 
    {
        $client = Client::with(['address','contactNumber', 'emailAddress', 'organization'])->get()->find($id);
        $client->profilePicture = $client->getMedia('client_profile_picture')->first()->getUrl();
        logActivity('Generated a Client Details Report');
        return view('pages.report.client.client-print-details')->with('client', $client);
    }
}
