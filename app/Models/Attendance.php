<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'ip', 'device', 'country_name', 'state_name', 'city_name', 'attendance_date', 'leave_date', 'latitude', 'longitude', 'start_time'
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

    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            if ($status == 'attendance') {
                return  $q->whereNotNull('attendance_date');
            } else {
                return  $q->whereNotNull('leave_date');
            }
        });
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('user_id', 'like', "%$search%")
                ->orWhere('ip', 'like', "%$search%")
                ->orWhere('device', 'like', "%$search%")
                ->orWhere('country_name', 'like', "%$search%")
                ->orWhere('state_name', 'like', "%$search%")
                ->orWhere('city_name', 'like', "%$search%");
        });
    }
}
