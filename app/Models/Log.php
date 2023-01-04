<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'user_type', 'log_type', 'description_ar', 'description_en'
    ];

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('description_ar', 'like', "%$search%")
                ->orWhere('description_en', 'like', "%$search%")
                ->orWhere('user_type', 'like', "$search")
                ->orWhere('log_type', 'like', "$search")
                ->orWhere('user_id', 'like', "$search");
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhenUserType($query, $user_type)
    {
        return $query->when($user_type, function ($q) use ($user_type) {
            return $q->where('user_type', 'like', "%$user_type%");
        });
    }

    public function scopeWhenLogType($query, $log_type)
    {
        return $query->when($log_type, function ($q) use ($log_type) {
            return $q->where('log_type', 'like', "%$log_type%");
        });
    }
}
