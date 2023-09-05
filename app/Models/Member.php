<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'note',
        'affiliation'
    ];

    protected $primaryKey = 'id';

    public function committeeMembers()
    {
        return $this->hasMany(CommitteeMember::class, 'id2');
    }

    public function committees()
    {
        return $this->belongsToMany(Committee::class, 'committee_members', 'id2', 'cId')
            ->withPivot('note')
            ->withTimestamps();
    }
}