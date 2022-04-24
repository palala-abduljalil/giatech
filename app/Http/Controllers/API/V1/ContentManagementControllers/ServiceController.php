<?php

namespace App\Http\Controllers\API\V1\ContentManagementControllers;

use App\Models\Company;

use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Services\Content\Service\StoreService;
use App\Services\Content\Service\UpdateService;

class ServiceController extends Controller
{
    public function index()
    {
        $services = ServiceResource::collection(Service::with([
            'coverImage',
            'createdBy.profilePicture',
            'createdBy.position'
        ])->orderBy('id', 'desc')->get());
        if (!auth()->user()->isAdmin()) {
            $services = ServiceResource::collection(Service::with([
                'coverImage'
            ])->orderBy('id', 'desc')->where('created_by', auth()->user()->employee_id)->get());
        }
        $serviceDescription = Company::first()->serviceDescription;
        return response()->json([
            'services' => $services,
            'serviceDescription' => $serviceDescription
        ]);
    }

    public function store(ServiceRequest $request)
    {
        $service = new StoreService($request->validated());
        $service->store();
        return response()->json([
            'message' => 'New Service added.'
        ]);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $updatedService = new UpdateService($request->validated(), $service);
        $updatedService->update();
        return response()->json([
            'message' => 'Service Information has been updated.'
        ]);
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json([
            'message' => 'Service successfully removed.'
        ]);
    }
}
