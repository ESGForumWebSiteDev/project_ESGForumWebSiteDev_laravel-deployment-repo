<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function login(LoginRequest $request)
  {
    $credentials = $request->only('userId', 'password');

    if (Auth::attempt($credentials)) {
      return response()->json([
        'message' => 'Login successful!'
      ], 200);
    }

    return response()->json([
      'error' => 'User ID and/or password is incorrect.'
    ], 401);
  }

  public function logout(Request $request)
  {
    Auth::logout();
    return;
  }
}