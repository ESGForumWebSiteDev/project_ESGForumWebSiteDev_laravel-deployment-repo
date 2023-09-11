<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
  const ADMIN_AUTHORITY = 1;
  public function handle(Request $request, Closure $next)
  {
    if (auth()->check() && auth()->user()->authority == self::ADMIN_AUTHORITY) {
      return $next($request);
    }

    return response()->json(['message' => '관리자만 접근 가능합니다.'], 403);
  }
}