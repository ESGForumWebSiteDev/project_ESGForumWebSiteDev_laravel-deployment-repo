<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Member;

class AdminMiddleware
{
  private function isAdmin($memberId)
  {
    $member = Member::find((int)$memberId);
    return ($member->authority === 1);
  }

  public function handle(Request $request, Closure $next)
  {
    $token = $request->header('Authorization');

    if (!$token) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    try {
      // JWT 디코딩
      $decoded = JWTAuth::setToken($token)->getPayload();

      $memberId = $decoded->get('sub');
      // 디코딩된 데이터 사용
      if ($this->isAdmin($memberId)) {
        return $next($request);
      }

      return response()->json(['message' => '관리자만 접근 가능합니다.'], 403);
    } catch (\Exception $e) {
      return response()->json(['message' => '관리자만 접근 가능합니다.'], 403);
    }
  }
}
