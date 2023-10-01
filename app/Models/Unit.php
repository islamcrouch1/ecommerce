<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name_ar', 'name_en', 'units_category_id', 'type', 'ratio'
    ];

    public function units_category()
    {
        return $this->belongsTo(UnitsCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_ar', 'like', "%$search%");
        });
    }
}
