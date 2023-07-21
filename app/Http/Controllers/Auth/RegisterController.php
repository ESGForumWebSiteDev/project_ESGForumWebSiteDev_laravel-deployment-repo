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
    User::create([
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'name' => $request->name,
      'affiliation' => $request->affiliation,
    ]);

    return response()->json([
        'message' => 'Registration successful! You can now log in.'
    ], 201);
  }
}