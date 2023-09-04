<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  /**
   * 회원가입 처리 메소드
   */
  public function store(RegisterRequest $request)
  {
    $user = User::create([
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'name' => $request->name,
      'affiliation' => $request->affiliation,
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
      'access_token' => $token,
      'message' => 'Registration successful! You can now log in.',
      'token_type' => 'Bearer',
    ], 201);
  }
}