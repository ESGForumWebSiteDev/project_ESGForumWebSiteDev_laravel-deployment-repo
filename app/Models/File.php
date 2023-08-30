<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = [
        'post_id',
        'filename',
    ];

    public function getUrlAttribute()
    {
        return url('/files/' . $this->filename);
    }
}