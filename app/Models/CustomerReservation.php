<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReservation extends Model
{
    use HasFactory;

    protected $table = 'customer_reservations';

    protected $fillable = [
        'customer_id',
        'dealer_id',
        'vehicle_id',
        'date_purchased',
        'date_delivered',
        'is_pending',
        'gender',
        'income',
        'delivery_address',
        'details',
        'price',
    ];

   // Define relationships if needed
   public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function manufacturerVehicle()
    {
        return $this->belongsTo(ManufacturerVehicle::class, 'vehicle_id');
    }
    public function vehicle()
    {
        return $this->belongsTo(ManufacturerVehicle::class, 'vehicle_id');
    }
}
