<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCombinationDtl extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_combination_id', 'variation_id', 'product_id'
    ];


    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
