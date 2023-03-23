<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class City extends Model
{
    use HasFactory;

    use SoftDeletes;


    protected $fillable = [
        'name_en', 'name_ar',  'shipping_amount', 'country_id', 'status', 'state_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }


    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_en', 'like', "%$search%")
                ->orWhere('name_ar', 'like', "%$search%")
                ->orWhere('country_id', 'like', "$search")
                ->orWhere('state_id', 'like', "$search")
                ->orWhere('status', 'like', "$search");
        });
    }


    public function scopeWhenState($query, $state_id)
    {
        return $query->when($state_id, function ($q) use ($state_id) {
            return $q->where('state_id', 'like', "$state_id");
        });
    }

    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "$country_id");
        });
    }
}
