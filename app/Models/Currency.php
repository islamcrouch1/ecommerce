<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Currency extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name_ar', 'name_en',  'symbol', 'decimal', 'status', 'country_id', 'is_default'
    ];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_ar', 'like', "%$search%")
                ->orWhere('symbol', 'like', "%$search%");
        });
    }


    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            return $q->where('Status', 'like', "%$status%");
        });
    }
}
