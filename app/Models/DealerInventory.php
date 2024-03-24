<?php

namespace App\Models;
use App\Models\User;
use App\Models\ManufacturerVehicle;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerInventory extends Model
{
    use HasFactory;
    
    protected $table = 'dealer_inventories';

    protected $fillable = [
        'dealer_id',
        'manufacturer_vehicle_id',
        'post',
        'trend',
        'new_price',
        'details',

    ];

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(ManufacturerVehicle::class, 'manufacturer_vehicle_id');
    }
     public function manufacturerVehicle()
    {
        return $this->belongsTo(ManufacturerVehicle::class, 'manufacturer_vehicle_id');
    }
}
