<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'explanation'
    ];

    protected $primaryKey = 'id';

    public function committeeMembers()
    {
        return $this->hasMany(CommitteeMember::class, 'cId');
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'committee_members', 'cId', 'id2')
                ->withPivot('note')
                ->withTimestamps();
    }
}
