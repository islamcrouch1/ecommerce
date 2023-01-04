<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'sender_id', 'sender_name', 'sender_image', 'title_ar', 'body_ar', 'date', 'url', 'title_en', 'body_en', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('title_ar', 'like', "%$search%")
                ->orWhere('title_en', 'like', "%$search%")
                ->orWhere('body_ar', 'like', "%$search%")
                ->orWhere('body_en', 'like', "%$search%");
        });
    }
}
