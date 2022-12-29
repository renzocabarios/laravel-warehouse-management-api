<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'color',
        'model',
        'image',
    ];

    public function shipments()
    {
        return $this->hasMany(Shipment::class, "shipmentId");
    }
}