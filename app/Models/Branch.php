<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'name',
        "address",
        "image",
        "branchOwnerId",
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class, "id");
    }

    public function branchOwner()
    {
        return $this->belongsTo(BranchOwner::class, "branchOwnerId");
    }
}
