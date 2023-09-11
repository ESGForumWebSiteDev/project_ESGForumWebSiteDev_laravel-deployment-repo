<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    /**
     * Logout Method
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $refreshToken = $request->user()->refresh_token;
        if ($refreshToken) {
            JWTAuth::setToken($refreshToken)->invalidate();
            $request->user()->refresh_token = null;
            $request->user()->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout successful!'
        ], 200);
    }
}