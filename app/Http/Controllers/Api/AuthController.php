<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'max:255', 'confirmed'],
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
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $data = $user;
        $data['token'] = $user->createToken('Token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $data
        ], 200);
    }
    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => []
            ], 401);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            $data = $user;
            $data['token'] = $user->createToken('Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User logged in successfully',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Wrong password or email',
                'data' => []
            ], 401);
        }
    }
    public function Logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(['Message' => 'Logged out successfully']);
    }
}
