<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_combination_id', 'warehouse_id', 'product_id', 'qty', 'customer_id', 'stock_status', 'reference_id', 'stock_type', 'created_by', 'updated_by', 'reference_price', 'limit'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }




    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->orWhere('product_id', 'like', "$search");
        });
    }
}
