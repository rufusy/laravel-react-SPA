<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends APIController
{
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->responseUnauthorized();
        }

        // Get the user data
        $user = auth()->user();

        return response()->json([
            'status' => 200,
            'message' => 'Authorized',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'name' => $user->name
            ]
        ], 200);
    }

    public function me()
    {
        return response()->json(['message'=> auth()->user()],200);
    }

    
}
