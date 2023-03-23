<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Client extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'user_id', 'name', 'phone', 'email', 'address', 'gender', 'place_type', 'whatsapp'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('phone', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('whatsapp', 'like', "$search")
                ->orWhere('place_type', 'like', "$search")
                ->orWhere('id', 'like', "$search")
                ->orWhere('address', 'like', "$search");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "%$country_id%");
        });
    }
}