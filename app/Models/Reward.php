<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;



    protected $fillable = [
        'user_id', 'amount', 'type', 'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhenUser($query, $user_id)
    {
        return $query->when($user_id, function ($q) use ($user_id) {
            return $q->where('user_id', 'like', "$user_id");
        });
    }



    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('user_id', 'like', "%$search%")
                ->orWhere('amount', 'like', "%$search%")
                ->orWhere('type', 'like', "%$search%")
                ->orWhere('note', 'like', "%$search%");
        });
    }
}
