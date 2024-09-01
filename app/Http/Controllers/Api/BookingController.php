<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $booking=Booking::search($request->search)->with(['tours.destinations','users','tickets'])->latest()->paginate(5);
        return response()->json($booking);
    }

//fetch customer bookings with tours and destination
     public function get_my_bookings(){
        $user = auth()->user();
        $bookings = Booking::with(['tours.destinations','users','tickets'])->where('user_id', $user->id)->latest()->paginate(10);
        return response()->json($bookings);
     }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id'=>'required',
            'amount'=>'required',
            'slots'=>'required'
        ]);

        try {
            $validated['user_id'] = Auth::id();
            $validated['status']=0;
            $booking = Booking::create($validated);

            Ticket::create(['booking_id'=>$booking->id]);
            //create Email with details.

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
            'amount'=>'required',
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
