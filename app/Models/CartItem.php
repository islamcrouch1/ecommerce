<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'warehouse_id', 'product_combination_id', 'user_id', 'qty', 'is_order', 'session_id', 'start_date', 'end_date', 'days'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function combination()
    {
        return $this->belongsTo(ProductCombination::class, 'product_combination_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
