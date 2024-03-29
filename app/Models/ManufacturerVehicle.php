<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturerVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'brand',
        'model',
        'price',
        'manufacturing_plant',
        'details',
        'color',
        'engine',
        'transmission',
        'manufacturer_id',
        'quantity',
       
    ];

    public function inventory()
    {
        return $this->hasOne(ManufacturerVehicleInventory::class, 'vehicle_id');
    }
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function manufacturer()
    {
        return $this->belongsTo(User::class, 'manufacturer_id');
    }

        public function dealerInventories()
    {
        return $this->hasMany(DealerInventory::class);
    }

    public function decreaseQuantity($amount = 1)
    {
        $this->quantity -= $amount;
        $this->save();
    }

    public function customerReservations()
    {
        return $this->hasMany(CustomerReservation::class, 'vehicle_id');
    }

    




}
