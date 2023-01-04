<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('stock_id', 'price', 'quantity', 'product_price', 'product_type', 'size_ar', 'size_en', 'color_ar', 'color_en')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
