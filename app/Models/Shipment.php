<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'isApproved',
        'vehicleId',
    ];

    protected $attributes = [
        'isApproved' => false
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, "vehicleId");
    }

    public function shipmentItems()
    {
        return $this->hasMany(ShipmentItem::class, "shipmentId");
    }
}