<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  public function register(RegisterRequest $request)
  {
    User::create([
      'userId' => $request->userId,
      'password' => Hash::make($request->password),
      'name' => $request->name,
      'affiliation' => $request->affiliation,
    ]);

    return response()->json([
      'message' => 'Registration successful! You can now log in.'
    ], 201);
  }
}