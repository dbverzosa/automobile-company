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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function manufacturer()
    {
        return $this->belongsTo(User::class, 'manufacturer_id');
    }
}
