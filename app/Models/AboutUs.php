<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
  use HasFactory;

  protected $table = 'forum_introduce';

  protected $fillable = [
    'objective',
    'vision',
    'history_and_purpose',
    'greetings',
    'rules',
    'ci_logo',
    'chairman_position',
    'chairman_name',
    'chairman_image',
  ];
}