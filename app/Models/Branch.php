<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name_ar', 'name_en', 'country_id', 'status', 'phone', 'email', 'address'
    ];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "$search")
                ->orWhere('phone', 'like', "$search")
                ->orWhere('email', 'like', "$search")
                ->orWhere('address', 'like', "$search");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "$country_id");
        });
    }
}
