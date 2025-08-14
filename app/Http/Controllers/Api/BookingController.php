<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/bookings",
     *      tags={"Bookings"},
     *      summary="Book a service (Customer only)",
     *      description="Creates a new booking for the authenticated customer",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"service_id","booking_date"},
     *              @OA\Property(property="service_id", type="integer", example=1),
     *              @OA\Property(property="booking_date", type="string", format="date", example="2025-08-20")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Booking created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Service booked successfully"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function store(BookingRequest $request)
    {
        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Service booked successfully',
            'data' => $booking
        ], 201);
    }


    /**
     * @OA\Get(
     *      path="/api/bookings",
     *      tags={"Bookings"},
     *      summary="Get logged-in customer's bookings",
     *      description="Returns a list of bookings made by the authenticated customer",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="List of bookings",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="service_id", type="integer", example=1),
     *                  @OA\Property(property="booking_date", type="string", format="date", example="2025-08-20"),
     *                  @OA\Property(property="status", type="string", example="pending"),
     *                  @OA\Property(property="service", type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Plumbing")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function myBookings(Request $request)
    {
        $bookings = $request->user()->bookings()->with('service')->latest()->get();
        return response()->json($bookings);
    }


    /**
     * @OA\Get(
     *      path="/api/admin/bookings",
     *      tags={"Bookings"},
     *      summary="Get all bookings (Admin only)",
     *      description="Returns a list of all bookings with user and service details",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="List of all bookings",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="user_id", type="integer", example=2),
     *                  @OA\Property(property="service_id", type="integer", example=1),
     *                  @OA\Property(property="booking_date", type="string", format="date", example="2025-08-20"),
     *                  @OA\Property(property="status", type="string", example="pending"),
     *                  @OA\Property(property="user", type="object",
     *                      @OA\Property(property="id", type="integer", example=2),
     *                      @OA\Property(property="name", type="string", example="John Doe"),
     *                      @OA\Property(property="email", type="string", example="john@example.com")
     *                  ),
     *                  @OA\Property(property="service", type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Plumbing")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function allBookings()
    {
        $bookings = Booking::with(['user', 'service'])->latest()->get();
        return response()->json($bookings);
    }
}
