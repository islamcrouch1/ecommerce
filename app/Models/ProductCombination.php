<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCombination extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'sku', 'sale_price', 'discount_price', 'media_id', 'limit',
    ];

    public function variations()
    {
        return $this->hasMany(ProductCombinationDtl::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'product_combination_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }




    public function scopeWhenProduct($query, $product)
    {
        return $query->when($product, function ($q) use ($product) {
            return $q->where('product_id', 'like', "$product");
        });
    }
}
