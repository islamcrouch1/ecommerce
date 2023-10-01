<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturingOrderComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'product_combination_id', 'done_qty', 'qty', 'unit_id', 'manufacturing_order_id', 'warehouse_id'
    ];
}
