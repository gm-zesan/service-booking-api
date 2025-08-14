<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
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

    public function myBookings(Request $request)
    {
        $bookings = $request->user()->bookings()->with('service')->latest()->get();
        return response()->json($bookings);
    }


    public function allBookings()
    {
        $bookings = Booking::with(['user', 'service'])->latest()->get();
        return response()->json($bookings);
    }
}
