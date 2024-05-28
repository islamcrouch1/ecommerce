<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_combination_id', 'unit_id', 'warehouse_id', 'product_id', 'status', 'serial', 'invoice_id', 'order_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function scopeWhenWarehouse($query, $warehouse_id)
    {
        return $query->when($warehouse_id, function ($q) use ($warehouse_id) {
            return $q->where('warehouse_id', 'like', "$warehouse_id");
        });
    }

    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            return $q->where('stock_status', 'like', "$status");
        });
    }

    public function scopeWhenProduct($query, $product)
    {
        return $query->when($product, function ($q) use ($product) {
            return $q->where('product_id', 'like', "$product");
        });
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->orWhere('product_id', 'like', "$search")
                ->orWhere('stock_status', 'like', "$search");
        });
    }
}
