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
    $MEMBER = config('MEMBER');
    $isMember = Member::where('email', $request->input('email'))->first();

    if ($isMember) {
      return response()->json([
        'error' => '이미 사용되고 있는 이메일 입니다.'
      ], 409);
    }
    
    $member = Member::where('name', $request->input('name'))
    ->where('affiliation', $request->input('affiliation'))
    ->where('authority', -1)
    ->first();
    
    // 관리자가 추가하지 않은 맴버
    if (!$member) {
      $member = Member::create([
        'name' => $request->name,
        'affiliation' => $request->affiliation,
        'authority' => $MEMBER,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ]);
    } else {
      
      if ($member->authority === $MEMBER) {
        return response()->json([
          'error' => '이미 가입된 정보입니다.'
        ], 409);
      }
      // 관리자가 추가한 맴버
      $member->email = $request->email;
      $member->password = Hash::make($request->password);
      $member->authority = $MEMBER;
      $member->save();
    }

    $token = $member->createToken('auth_token')->plainTextToken;

    return response()->json([
      'access_token' => $token,
      'message' => 'Registration successful! You can now log in.',
      'token_type' => 'Bearer',
    ], 201);
  }
}
