<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  /**
   * 로그인 처리 메소드
   */
  public function login(LoginRequest $request)
  {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('web')->attempt($credentials)) {
      $user = User::firstWhere('email', $request->email);
      $tokenExpirationDays = config('auth.personal_access_tokens.expire_after_days');
      $token = $user->createToken('api-token', [], now()->addDays($tokenExpirationDays))->plainTextToken;

      return response()->json([
        'success' => true,
        'message' => '로그인 성공!',
        'token' => $token
      ], 200);
      }

      return response()->json([
        'success' => false,
        'error' => '이메일 또는 비밀번호가 올바르지 않습니다.'
      ], 401);
  }
}