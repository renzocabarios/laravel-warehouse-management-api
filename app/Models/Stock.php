<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'branchId',
        'itemId',
        'quantity',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, "itemId");
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, "branchId");
    }
}
