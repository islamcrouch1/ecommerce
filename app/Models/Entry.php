<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id', 'reference_id', 'type', 'warehouse_id', 'dr_amount', 'cr_amount', 'description', 'created_by', 'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function scopeWhenAccount($query, $account_id)
    {
        return $query->when($account_id, function ($q) use ($account_id) {
            return $q->where('account_id', 'like', "$account_id");
        });
    }



    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('description', 'like', "%$search%");
        });
    }
}
