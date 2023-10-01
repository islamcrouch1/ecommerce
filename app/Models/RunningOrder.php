<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunningOrder extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_combination_id', 'unit_id', 'warehouse_id', 'product_id', 'requested_qty', 'approved_qty', 'returned_qty', 'user_id', 'stock_status', 'reference_id', 'stock_type', 'created_by', 'updated_by', 'status', 'notes', 'stock_id'
    ];


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }



    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function stock()
    {
        return $this->belongsTo(Stock::class);
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

    public function scopeWhenStockStatus($query, $stock_status)
    {
        return $query->when($stock_status, function ($q) use ($stock_status) {
            return $q->where('stock_status', 'like', "$stock_status");
        });
    }


    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            return $q->where('status', 'like', "$status");
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
