<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (
            !auth()->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])
        ) {

            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Credentials not match',
            ]);
        }

        $token = auth()->user()->createToken('MyApp')->accessToken;

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Authentication success',
            'token' => $token,
        ]);
    }
}