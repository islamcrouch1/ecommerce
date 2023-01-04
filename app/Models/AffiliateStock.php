<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'color_id', 'size_id', 'product_id', 'quantity', 'image', 'affiliate_order_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('stock', 'like', "%$search%")
                ->orWhere('color_id', 'like', "%$search%")
                ->orWhere('size_id', 'like', "%$search%")
                ->orWhere('product', 'like', "%$search%");
        });
    }
}
