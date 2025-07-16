<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $tokenResult = $user->createToken('api-token', ['*'], now()->addDay());
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user'  => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Clean up expired tokens
        $user->tokens()->where('expires_at', '<', now())->delete();

        // Check for existing valid token
        $validToken = $user->tokens()
            ->where('expires_at', '>', now())
            ->latest('created_at')
            ->first();

        if ($validToken) {
            // Return the existing token (cannot return plain text, so ask user to login again if lost)
            return response()->json([
                'success' => true,
                'message' => 'Login successful (existing token still valid)',
                'user'  => $user,
                'token' => null, // Cannot return plain text token again
                'note'  => 'Your previous token is still valid. Please use your existing token.'
            ]);
        }

        // Create a new token if none is valid
        $tokenResult = $user->createToken('api-token', ['*'], now()->addDay());
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user'  => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
