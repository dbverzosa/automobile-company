<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturerSale extends Model
{
    protected $table = "manufacturer_vehicle_sales";

    protected $fillable = [
        'vehicle_id',
        'dealer_id',
        'manufacturer_id',
        'sale_price',
        'quantity_sold',
        'total_price',
        'quantity_sold', // Add this line
    'total_sales',   // Add this line
    ];

    public function vehicle()
    {
        return $this->belongsTo(ManufacturerVehicle::class, 'vehicle_id');
    }

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(User::class, 'manufacturer_id');
    }

    public function getQuantitySoldAttribute()
    {
        $inventory = ManufacturerVehicleInventory::where('vehicle_id', $this->vehicle_id)->first();
        if ($inventory) {
            return $inventory->is_sold ? 1 : 0;
        }
        return 0;
    }

    public function getTotalSalesAttribute()
    {
        $inventory = ManufacturerVehicleInventory::where('vehicle_id', $this->vehicle_id)->first();
        if ($inventory) {
            return $this->sale_price * ($inventory->is_sold ? 1 : 0);
        }
        return 0;
    }
}
