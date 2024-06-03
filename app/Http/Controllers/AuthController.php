<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\loginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
{
    try {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $token = $user->createToken('auth_token')->plainTextToken;


       return(new RegisterResource($user))
       ->additional(['message '=>'User registered successfully'])
       ->response()->setStatusCode(201);

    } catch (\Exception $e) {

        return response()->json(['error' =>$e->getMessage()], 500);
    }
}

    public function login(loginRequest $request)
    {

            $request->authenticate();
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('api_token')->plainTextToken;
            $response = [
                'message' => 'Login successful',
                'data' => [
                    'user' => new loginResource($user),
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]
            ];
            return response()->json($response,200);


    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
