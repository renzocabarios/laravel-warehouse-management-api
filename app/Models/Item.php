<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'name',
        "description",
        'image',
    ];

    protected $attributes = [
        'image' => 'test'
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function shipmentItem()
    {
        return $this->belongsTo(ShipmentItem::class, "itemId");
    }
}