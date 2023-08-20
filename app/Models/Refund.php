<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'reason', 'status', 'refuse_reason', 'type', 'product_id', 'combination_id', 'qty'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function combination()
    {
        return $this->belongsTo(ProductCombination::class);
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
