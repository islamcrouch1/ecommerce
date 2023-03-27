<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Variation extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name_ar', 'name_en', 'value', 'attribute_id'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function combinations()
    {
        return $this->hasMany(ProductCombination::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "%$search%");
        });
    }

    public function scopeWhenAttribute($query, $attribute_id)
    {
        return $query->when($attribute_id, function ($q) use ($attribute_id) {
            return $q->where('attribute_id', 'like', "%$attribute_id%");
        });
    }
}
