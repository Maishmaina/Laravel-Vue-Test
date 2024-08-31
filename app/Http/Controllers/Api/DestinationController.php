<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
         $destination=Destination::search($request->search)->withCount('tours')->latest()->paginate(10);
         return response()->json($destination);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        try {

            $destination = Destination::create($validated);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create destination',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Destination created successfully',
            'destination' => $destination
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        return response()->json($destination);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        try {
            
            $destination->update($validated);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update destination',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Destination updated successfully',
            'destination' => $destination->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        return $this->destroyModel($destination);
    }
}
