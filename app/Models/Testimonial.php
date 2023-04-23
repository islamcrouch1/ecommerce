<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Testimonial extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name_ar', 'name_en',  'title_en', 'title_ar', 'country_id',  'description_ar', 'description_en', 'media_id', 'rating'
    ];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_ar', 'like', "%$search%")
                ->orWhere('title_en', 'like', "%$search%")
                ->orWhere('title_ar', 'like', "%$search%")
                ->orWhere('description_ar', 'like', "%$search%")
                ->orWhere('description_en', 'like', "%$search%");
        });
    }

    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "$country_id");
        });
    }
}
