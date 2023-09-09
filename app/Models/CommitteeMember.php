<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'note'
    ];

    // 상위 위원회 정보
    public function committee()
    {
        return $this->belongsTo(Committee::class, 'cId');
    }

    // 회원 정보
    public function member()
    {
        return $this->belongsTo(Member::class, 'id2');
    }
}
