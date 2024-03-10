<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleVin extends Model
{
    use HasFactory;

    protected $fillable = ['manufacturer_vehicle_id', 'vin'];

    public function manufacturerVehicle()
    {
        return $this->belongsTo(ManufacturerVehicle::class);
    }
}

