<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'balance_id', 'order_id', 'request_ar', 'request_en', 'balance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('request_ar', 'like', "%$search%")
                ->where('request_en', 'like', "%$search%");
        });
    }
}
