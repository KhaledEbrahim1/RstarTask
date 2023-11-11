<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    // ONLY ADMIN CAN RETRIEVE ALL USERS
    public function index()
    {
        $Users = User::all();

        return response()->json([
            'Success' => true,
            'Message' => 'User retrieved successfully',
            'data' => $Users
        ], 200);
    }
    public function show(string $id)
    {

        // Find the user by ID
        $User = User::find($id);

        // Check if the user exists
        if (!$User) {
            return response()->json([
                'Success' => false,
                'Message' => 'User not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'Success' => true,
            'Message' => 'User found',
            'data' => $User
        ], 200);
    }
    public function update(Request $request, string $id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'min:8', 'max:255', 'confirmed'],
            'phone' => ['required', 'max:255'],
            'type' => ['required', 'in:Admin,User']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => []
            ], 422);
        }

        $input = $request->all();

        // Update user data
        if (isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }

        $user->update($input);

        $data = $user;
        $data['token'] = $user->createToken('Token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $data
        ], 200);

    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json([
                'Success' => false,
                'Message' => 'User not found',
                'data' => []
            ], 404);
        }

        $user->delete();

        return response()->json([
            'Success' => true,
            'Message' => 'User deleted successfully',
            'data' => []
        ], 200);
    }

}
