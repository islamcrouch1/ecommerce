<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id', 'variation_id', 'product_id'
    ];


    public function variation()
    {
        return $this->belongsTo(Variation::class, 'variation_id');
    }
}
