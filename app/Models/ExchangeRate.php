<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExchangeRate extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'currency_id', 'default_currency_id',  'rate'
    ];


    public function default_currency()
    {
        return $this->belongsTo(Currency::class, 'default_currency_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('rate', 'like', "%$search%");
        });
    }
}
