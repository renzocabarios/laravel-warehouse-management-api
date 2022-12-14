<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentItem extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'itemId',
        "quantity",
        'shipmentId',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, "itemId");
    }
    
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, "shipmentId");
    }
}