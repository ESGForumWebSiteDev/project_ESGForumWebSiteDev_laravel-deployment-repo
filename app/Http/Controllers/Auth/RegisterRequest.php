<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'userId' => 'required|string|unique:users|max:20',
      'password' => 'required|string|confirmed|max:255',
      'name' => 'required|string|max:40',
      'affiliation' => 'required|string|max:40',
    ];
  }
}