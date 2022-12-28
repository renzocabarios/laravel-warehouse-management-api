<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'email',
        "firstName",
        "lastName",
        'password',
        'image',
    ];

    protected $hidden = [
        'password',
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