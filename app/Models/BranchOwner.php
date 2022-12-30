<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchOwner extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'userId',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "userId");
    }

    public function branch()
    {
        return $this->hasMany(Branch::class, "branchOwnerId");
    }
}