<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RefreshTokenController extends Controller
{
    public function refreshToken(Request $request)
    {
        $token = $request->input('refreshToken');

        try {
            $user = Member::where('refresh_token', $token)->firstOrFail();

            $newAccessToken = JWTAuth::fromUser($user, ['exp' => now()->addMinutes(60)->timestamp]);

            return response()->json([
                'success' => true,
                'message' => '새로운 accessToken 발급 성공!',
                'token' => $newAccessToken,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'error' => '유효하지 않은 refreshToken 입니다.',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'error' => '토큰 생성에 실패하였습니다.',
            ], 500);
        }
    }
}