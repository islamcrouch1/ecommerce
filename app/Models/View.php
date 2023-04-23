<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'session_id', 'ip', 'url', 'full_url', 'country_name', 'state_name', 'city_name', 'device'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('ip', 'like', "%$search%")
                ->orWhere('full_url', 'like', "$search")
                ->orWhere('country_name', 'like', "$search")
                ->orWhere('state_name', 'like', "%$search%")
                ->orWhere('city_name', 'like', "%$search%")
                ->orWhere('device', 'like', "%$search%");
        });
    }
}
