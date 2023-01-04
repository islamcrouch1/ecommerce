<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'notes', 'is_default_billing', 'is_default_shipping', 'user_id', 'session_id', 'phone'
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
