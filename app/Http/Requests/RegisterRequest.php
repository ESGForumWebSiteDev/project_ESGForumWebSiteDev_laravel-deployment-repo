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
      'userId' => 'required|max:20',
      'password' => 'required|max:255',
      'name' => 'required|max:40',
      'affiliation' => 'required|max:40',
    ];
  }
}