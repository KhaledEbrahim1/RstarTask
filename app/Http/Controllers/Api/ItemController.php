<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('category','category.partitions')->get();

        return response()->json([
            'success' => true,
            'message' => 'items retrieved successfully',
            'data' => $items
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
            'partition_id' => ['required'],

        ]);


        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => []
            ], 422);
        }


        $item = Item::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'partition created successfully',
            'data' => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::with('category','partition')->find($id);

        if (is_null($item)) {

            return response()->json([
                'success' => false,
                'message' => 'item not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'item retrieved successfully',
            'data' => $item

        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $item = Item::find($id);

        if (is_null($item)) {

            return response()->json([
                'success' => false,
                'message' => 'item not found',
                'data' => []
            ], 404);
        }

        $item->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'item updated successfully',
            'data' => $item

        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::find($id);

        if (is_null($item)) {

            return response()->json([
                'success' => false,
                'message' => 'item not found',
                'data' => []
            ], 404);

        } else {
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => 'item deleted successfully',
                'data' => []
            ], 200);


        }
    }
}
