<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ManageClientController extends Controller
{
    public function index()
    {
        return view('pages.client.index');
    }

    public function create()
    {
        return view('pages.client.create');
    }

    public function show(Client $client)
    {
        return view('pages.client.show')->with('id', $client->id);
    }

    public function edit(Client $client)
    {
        return view('pages.client.edit')->with('id', $client->id);
    }
}
