<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingRate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'country_id', 'city_ar', 'city_en', 'cost',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "%$country_id%");
        });
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('city_ar', 'like', "%$search%")
                ->orWhere('city_en', 'like', "%$search%")
                ->orWhere('cost', 'like', "%$search%");
        });
    }
}
