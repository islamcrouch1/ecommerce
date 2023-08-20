<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address',  'house', 'special_mark', 'block', 'avenue', 'floor_no', 'delivery_time', 'notes', 'is_default_billing', 'is_default_shipping', 'user_id', 'session_id', 'phone', 'phone2', 'country_id', 'state_id', 'city_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
