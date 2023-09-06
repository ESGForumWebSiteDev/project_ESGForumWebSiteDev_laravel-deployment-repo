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
        'affiliation',
        'authority',
        'email',
        'password',
    ];

    protected $primaryKey = 'id';

    protected $attributes = [
        'password' => 'applicant',
        'authority' => -1,
        'note' => null
    ];

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * 
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return (string)$this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * 
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 관리자 여부 판단
     */
    public function isAdmin()
    {
        return $this->authority == 1;
    }
}