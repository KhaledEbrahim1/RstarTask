<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::with('partitions','partitions.items')->get();

        return response()->json([
            'Success' => true,
            'Message' => 'categorys retrieved successfully',
            'data' => $category
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name_en' => ['required', 'max:255'],
            'name_ar' => ['required', 'max:255'],

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => []
            ], 422);
        }

        $category = Category::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'category created successfully',
            'data' => $category

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            return response()->json([
                'success' => false,
                'message' => 'category not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'category retrieved successfully',
            'data' => $category
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $category = Category::find($id);

        if (is_null($category)) {

            return response()->json([
                'success' => false,
                'message' => 'category not found',
                'data' => []
            ], 404);
        }


        $validator = Validator::make($request->all(), [
            'name_en' => ['required', 'max:255'],
            'name_ar' => ['required', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => []
            ], 422);
        }

        $category->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'category updated successfully',
            'data' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (is_null($category)) {

            return response()->json([
                'success' => false,
                'message' => 'category not found',
                'data' => []
            ], 404);
        } else {

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'category deleted successfully',
                'data' => []
            ], 200);
        }
    }
}
