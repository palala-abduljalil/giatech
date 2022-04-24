<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Services\Client\StoreClientService;
use App\Services\Client\UpdateClientService;

class ClientController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return ClientResource::collection(Client::with([
                'profilePicture',
                'address',
                'contactNumber',
                'emailAddress',
                'organization'
            ])->where('created_by', auth()->user()->employee_id)->get());
        }
        return ClientResource::collection(Client::with([
            'profilePicture',
            'address',
            'contactNumber',
            'emailAddress',
            'createdBy.profilePicture',
            'createdBy.position',
            'organization'
        ])->get());
    }

    public function store(StoreClientRequest $request)
    {
        $client = new StoreClientService($request->validated());
        $client->storeClient();
        return response()->json([
            'message' => 'Client has been registered.'
        ]);
    }

    public function show(Client $client)
    {
        return new ClientResource(Client::with([
            'profilePicture',
            'address',
            'contactNumber',
            'emailAddress',
            'organization'
        ])->find($client->id));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $updatedClient = new UpdateClientService($request->validated(), $client);
        $updatedClient->updateClient();
        return response()->json([
            'client' => new ClientResource(Client::with([
                'address',
                'contactNumber',
                'emailAddress',
                'organization'
            ])->find($client->id)),
            'message' => 'Client has been updated'
        ]);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->noContent();
    }
}
