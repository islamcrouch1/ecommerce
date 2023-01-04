<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'amount',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('type', 'like', "%$search%")
                ->orWhere('user_id', 'like', "$search");
        });
    }
}
