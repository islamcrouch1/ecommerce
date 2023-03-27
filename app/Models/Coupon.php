<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;



    protected $fillable = [
        'code', 'amount',  'type', 'user_type', 'ended_at', 'country_id', 'frequency', 'max_value'
    ];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('code', 'like', "%$search%")
                ->orWhere('type', 'like', "%$search%");
        });
    }

    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "$country_id");
        });
    }
}
