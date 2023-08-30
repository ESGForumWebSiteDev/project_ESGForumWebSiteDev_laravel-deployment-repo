<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
  use HasFactory;

  protected $table = 'seminars';

  protected $fillable = [
    'date_start',
    'date_end',
    'location',
    'subject',
    'host',
    'supervision',
    'participation',
    'content'
  ];
}