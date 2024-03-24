<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturerVehicleInventory extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'is_sold'];

    public function vehicle()
    {
        return $this->belongsTo(ManufacturerVehicle::class, 'vehicle_id');
    }
}
