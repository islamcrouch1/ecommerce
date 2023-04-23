<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Country extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name_en', 'name_ar', 'code', 'currency', 'media_id', 'status', 'shipping_amount', 'is_default', 'phone_digits'
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "%$search%");
        });
    }
}
