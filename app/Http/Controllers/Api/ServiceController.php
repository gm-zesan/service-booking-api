<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::where('status', 'active')->get();
    }


    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());
        return response()->json(['message' => 'Service created', 'data' => $service], 201);
    }


    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());
        return response()->json(['message' => 'Service updated', 'data' => $service]);
    }


    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['message' => 'Service deleted']);
    }
}
