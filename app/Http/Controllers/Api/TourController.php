<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tour=Tour::latest()->paginate();
        return response()->json($tour);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        
            'destination_id'=>'required',
            'name'=>'required',
             'description'=>'required',
             'price'=>'required',
             'slots'=>'required',
        ]);

        try {

            $tour = Tour::create($validated);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create tour',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Tour created successfully',
            'tour' => $tour
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tour $tour)
    {
        return response()->json($tour);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
        
            'destination_id'=>'required',
            'name'=>'required',
             'description'=>'required',
             'price'=>'required',
             'slots'=>'required',
        ]);

        try {
            $tour->update($validated);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update Tour',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Tour updated successfully',
            'tour' => $tour->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tour $tour)
    {
        return $this->destroyModel($tour);
    }
}
