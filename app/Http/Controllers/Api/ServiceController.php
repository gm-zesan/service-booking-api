<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/services",
     *      tags={"Services"},
     *      summary="Get list of active services",
     *      description="Returns all active services",
     *      @OA\Response(
     *          response=200,
     *          description="List of services",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Plumbing"),
     *                  @OA\Property(property="description", type="string", example="Fix leaks, install pipes"),
     *                  @OA\Property(property="price", type="number", example=500.00),
     *                  @OA\Property(property="status", type="string", example="active")
     *              )
     *          )
     *      )
     * )
     */
    public function index()
    {
        return Service::where('status', 'active')->get();
    }


    /**
     * @OA\Post(
     *      path="/api/services",
     *      tags={"Services"},
     *      summary="Create a new service (Admin only)",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","price","status"},
     *              @OA\Property(property="name", type="string", example="Gardening"),
     *              @OA\Property(property="description", type="string", example="Lawn mowing, planting"),
     *              @OA\Property(property="price", type="number", example=600.00),
     *              @OA\Property(property="status", type="string", example="active")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Service created",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Service created"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function store(ServiceRequest $request)
    {
        $data = $request->only(['name', 'description', 'price', 'status']);
        $service = Service::create($data);
        return response()->json(['message' => 'Service created', 'data' => $service], 201);
    }



    /**
     * @OA\Put(
     *      path="/api/services/{id}",
     *      tags={"Services"},
     *      summary="Update a service (Admin only)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Service ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Plumbing Deluxe"),
     *              @OA\Property(property="description", type="string", example="Advanced plumbing services"),
     *              @OA\Property(property="price", type="number", example=750.00),
     *              @OA\Property(property="status", type="string", example="active")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Service updated",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Service updated"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Not Found")
     * )
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->only(['name', 'description', 'price', 'status']);
        $service->update($data);
        return response()->json(['message' => 'Service updated', 'data' => $service]);
    }


    /**
     * @OA\Delete(
     *      path="/api/services/{id}",
     *      tags={"Services"},
     *      summary="Delete a service (Admin only)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Service ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Service deleted",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Service deleted")
     *          )
     *      ),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Not Found")
     * )
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['message' => 'Service deleted']);
    }
}
