<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'available_balance', 'outstanding_balance', 'pending_withdrawal_requests', 'completed_withdrawal_requests', 'bonus'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}
