<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['model_part_id', 'quantity_sold', 'quantity_remaining'];

    public function modelPart()
    {
        return $this->belongsTo(ModelParts::class);
    }
   
}
