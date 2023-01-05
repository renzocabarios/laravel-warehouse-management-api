<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    public $primarykey = 'id';

    protected $fillable = [
        'email',
        "firstName",
        "lastName",
        'password',
        'image',
        'type',

    ];

    protected $attributes = [
        'image' => 'test',
        'type' => 'BRANCHOWNER'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->hasOne(Admin::class, "userId");
    }

    public function branchOwner()
    {
        return $this->hasOne(BranchOwner::class, "userId");
    }
}