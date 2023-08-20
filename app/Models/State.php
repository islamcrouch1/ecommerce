<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class State extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name_en', 'name_ar',  'shipping_amount', 'country_id', 'status', 'shipping_company_id'
    ];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function cities()
    {
        return $this->hasMany(City::class);
    }




    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_en', 'like', "%$search%")
                ->orWhere('name_ar', 'like', "%$search%")
                ->orWhere('country_id', 'like', "$search")
                ->orWhere('status', 'like', "$search");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "%$country_id%");
        });
    }
}
