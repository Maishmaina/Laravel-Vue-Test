<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Booking;
use App\Models\User;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function returnTopCountService()
    {
        $tourCount = Tour::count();
        $bookingCount = Booking::count();
        $userCount = User::count();
        $destinationCount = Destination::count();

        return response()->json([
            'tours' => $tourCount,
            'bookings' => $bookingCount,
            'users' => $userCount,
            'destinations' => $destinationCount,
        ]);
    }

    public function returnTotalEarnings()
    {
        $booking=Booking::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as label, SUM(amount) as y')
                            ->groupBy('label')
                            ->orderBy('label', 'desc')
                            ->get();
        return response()->json($booking);
    }
   //get sum on booking
    public function returnBookingAmountBooing()
    {
        $total_payment = Booking::sum('amount');
        $pending_payment= Booking::where('status', 0)->sum('amount');
        $received_payment = Booking::where('status', 1)->sum('amount');
        $rejected_payment = Booking::where('status', 2)->sum('amount');

        return response()->json([
            'total_payment' => number_format($total_payment,2),
            'pending_payment' => number_format($pending_payment,2),
            'received_payment' => number_format($received_payment,2),
            'rejected_payment' => number_format($rejected_payment,2),
        ]);
    }
    
}
