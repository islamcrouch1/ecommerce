<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EmployeePermission extends Model
{
    use HasFactory;
    use SoftDeletes;



    protected $fillable = [
        'user_id', 'admin_id', 'media_id', 'status',  'type', 'reason', 'date'
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }


    public function media()
    {
        return $this->belongsTo(Media::class);
    }


    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            return $q->where('status', 'like', "$status");
        });
    }


    public function scopeWhenType($query, $type)
    {
        return $query->when($type, function ($q) use ($type) {
            return $q->where('type', 'like', "$type");
        });
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('reason', 'like', "%$search%")
                ->orWhere('status', 'like', "%$search%")
                ->orWhere('type', 'like', "%$search%");
        });
    }
}
