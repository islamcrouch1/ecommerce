<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Offer extends Model
{

    use HasFactory;
    use SoftDeletes;



    protected $fillable = [
        'name_ar', 'name_en',  'ended_at', 'country_id',  'products', 'categories', 'type', 'amount', 'qty'
    ];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_ar', 'like', "%$search%");
        });
    }

    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "$country_id");
        });
    }
}
