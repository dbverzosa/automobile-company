<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelParts extends Model
{
    use HasFactory;

    protected $table = "model_parts";
    
    protected $fillable = [
        'model_name',
        'image',
        'price',
        'quantity',
        'date_supplied',
        'is_available',
        'supplier_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function supplier()
{
    return $this->belongsTo(User::class, 'supplier_id');
}
    public function inventorySales()
    {
        return $this->hasOne(InventorySales::class, 'model_part_id');
    }
}
