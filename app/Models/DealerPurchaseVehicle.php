<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerPurchaseVehicle extends Model
{
    use HasFactory;

    protected $table = 'dealer_purchase_vehicles';

    protected $fillable = [
        'manufacturer_vehicle_id',
        'dealer_id',
        'date_purchased',
    ];

    public function manufacturerVehicle()
    {
        return $this->belongsTo(ManufacturerVehicle::class, 'manufacturer_vehicle_id');
    }

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

}
