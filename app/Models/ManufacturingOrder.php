<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ManufacturingOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'product_combination_id', 'scheduled_date', 'qty', 'unit_id', 'sales_id', 'bom_id', 'status', 'manufacturer_id', 'order_id'
    ];




    public function scopeWhenProduct($query, $product)
    {
        return $query->when($product, function ($q) use ($product) {
            return $q->where('product_id', 'like', "$product");
        });
    }
}
