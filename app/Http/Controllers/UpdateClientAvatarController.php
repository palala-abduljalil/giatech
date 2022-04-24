<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class UpdateClientAvatarController extends Controller
{
    public function update(Request $request, Client $client)
    {
        if ($request->hasFile('image')) {
            $client->addMedia($request->file('image'))->toMediaCollection('client_profile_picture');
            logActivity('Has updated client profile picture');
            return response()->json(['message' => 'Client Profile Picture has been updated']);
        }
        return response()->json(['message' => '']);
    }
}
