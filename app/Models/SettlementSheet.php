<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettlementSheet extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id', 'name', 'amount', 'admin_id',  'branch_id', 'status'
    ];


    public function delete()
    {
        $this->records()->delete();
        return parent::delete();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function records()
    {
        return $this->hasMany(SettlementRecord::class);
    }



    public function scopeWhenUser($query, $user_id)
    {
        return $query->when($user_id, function ($q) use ($user_id) {
            return $q->where('user_id', 'like', "$user_id");
        });
    }

    public function scopeWhenBranch($query, $branch_id)
    {
        return $query->when($branch_id, function ($q) use ($branch_id) {
            return $q->where('branch_id', 'like', "%$branch_id%");
        });
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name', 'like', "%$search%")
                ->orWhere('user_id', 'like', "$search")
                ->orWhere('admin_id', 'like', "$search");
        });
    }
}
