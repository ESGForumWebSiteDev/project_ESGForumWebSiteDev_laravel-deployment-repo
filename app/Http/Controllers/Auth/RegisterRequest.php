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
      'userId' => 'required|unique:users|max:20',
      'password' => 'required|confirmed|max:255',
      'name' => 'required|max:40',
      'affiliation' => 'required|max:40',
    ];
  }
}