<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking=Booking::latest()->paginate();
        return response()->json($booking);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        
            'tour_id'=>'required'
        ]);

        try {
            $validated['user_id'] = Auth::id();
            $validated['status']=0;
            $booking = Booking::create($validated);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create booking',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return response()->json($booking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
        
            'tour_id'=>'required',
            'status'=>'required',
        ]);

        try {
         
            $booking->update($validated);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update booking',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking->fresh()
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        return $this->destroyModel($booking);
        
    }
}
