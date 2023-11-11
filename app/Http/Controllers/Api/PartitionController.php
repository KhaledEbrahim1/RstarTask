<?php

namespace App\Http\Controllers\Api;

use App\Models\Partition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PartitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partitons = Partition::with('category','items')->get();

        return response()->json([
            'success' => true,
            'message' => 'partitons retrieved successfully',
            'data' => $partitons
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => ['required', 'max:255'],
            'name_ar' => ['required', 'max:255'],
            'category_id' => ['required'],

        ]);


        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => []
            ], 422);
        }

        $partition = Partition::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'partition created successfully',
            'data' => $partition
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $partition = Partition::with('category')->find($id);

        if (is_null($partition)) {

            return response()->json([
                'success' => false,
                'message' => 'partition not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'partition retrieved successfully',
            'data' => $partition
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $partition = Partition::find($id);

        if (is_null($partition)) {

            return response()->json([
                'success' => false,
                'message' => 'partition not found',
                'data' => []
            ], 404);
        }

        $partition->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'category updated successfully',
            'data' => $partition
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partition = Partition::find($id);

        if (is_null($partition)) {

            return response()->json([
                'success' => false,
                'message' => 'partition not found',
                'data' => []
            ], 404);
        }

        $partition->delete();

        return response()->json([
            'success' => true,
            'message' => 'partition deleted successfully',
            'data' => []

        ], 200);
    }
}
