<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory;

    use SoftDeletes;


    protected $fillable = [
        'size_ar', 'size_en'
    ];


    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function affiliate_stocks()
    {
        return $this->hasMany(AffiliateStock::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('size_ar', 'like', "%$search%")
                ->orWhere('size_en', 'like', "%$search%");
        });
    }
}
