<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventorySales extends Model
{
    use HasFactory;

    protected $table = "inventory_sales";

    protected $fillable = [
        'model_part_id',
        'price',
        'total_quantity',
        'remaining_quantity',
        'sold_quantity',
        'total_sales',
        
    ];

    public function modelPart()
    {
        return $this->belongsTo(ModelParts::class, 'model_part_id');
    }
}
