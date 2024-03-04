<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseModelParts extends Model
{
    use HasFactory;

    protected $table = "purchase_parts";

    protected $fillable = [
        'model_id',
        'supplier_id',
        'manufacturer_id',
        'quantity',
        'price',
        'total_price',
        'details',
        'date_purchased',

    ];

    public function modelPart()
    {
        return $this->belongsTo(ModelParts::class, 'model_id');
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(User::class, 'manufacturer_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
