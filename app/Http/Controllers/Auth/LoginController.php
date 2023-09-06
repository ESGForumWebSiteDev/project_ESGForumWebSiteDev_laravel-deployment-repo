<?php

namespace App\Http\Controllers\Auth;

use App\Models\Member;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
  /**
   * 로그인 처리 메소드
   */
  public function login(LoginRequest $request)
  {
    $credentials = $request->only('email', 'password');
    $member = Member::where('email', $credentials['email'])->first();

    if ($member && $member->authority !== null && ($member->authority == 0 || $member->authority == 1)) {
      try {
        if ($token = JWTAuth::attempt($credentials)) {
          $refreshToken = JWTAuth::fromUser($member, ['exp' => now()->addDays(30)->timestamp]);

          $member->refresh_token = $refreshToken;
          $member->save();

          return response()->json([
            'success' => true,
            'message' => '로그인 성공!',
            'token' => $token,
            'refreshToken' => $refreshToken,
          ], 200);
        }

        return response()->json([
          'success' => false,
          'error' => '이메일 또는 비밀번호가 올바르지 않습니다.'
        ], 401);
      } catch (JWTException $e) {
        return response()->json([
          'success' => false,
          'error' => '토큰 생성에 실패하였습니다.',
        ], 500);
      }
    } else {
      return response()->json([
        'success' => false,
        'error' => '로그인을 할 수 없는 유저입니다. 관리자에게 문의해주세요.',
      ], 403);
    }
  }
}