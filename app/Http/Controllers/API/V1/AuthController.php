<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {

        // Get only the validated data
        $validatedData = $request->validated();

        try{
            // Create the user using validated data
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']), // Hash the password before saving
            ]);

            return response()->json([
                'message' => 'User Registered Successfully!'
            ],201);

        } catch(\Exception $ex) {
            return response()->json([
                'errors' => 'Internal server error'
            ], 500);
        }
    }

    public function login(LoginRequest $request) {

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token =  $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'userId' => $user->id
        ], 201);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Revoke all tokens...
        //$request->user()->tokens()->delete();

        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'User Logged out successfully'], 201);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function checkUserStatus() {
        $status = Auth::check() ? true : false;

        return response()->json(['status' => $status], 200);
    }

}
