<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  /**
   * 회원가입 처리 메소드
   */
  public function store(RegisterRequest $request)
  {
    $member = Member::create([
      'name' => $request->name,
      'note' => null,
      'affiliation' => $request->affiliation,
      'authority' => null,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    $token = $member->createToken('auth_token')->plainTextToken;

    return response()->json([
      'access_token' => $token,
      'message' => 'Registration successful! You can now log in.',
      'token_type' => 'Bearer',
    ], 201);
  }
}