<?php

namespace App\Http\Requests;

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
      'email' => 'required|string|max:20',
      'password' => 'required|string|max:255',
      'name' => 'required|string|max:40',
      'affiliation' => 'required|string|max:40',
    ];
  }
}