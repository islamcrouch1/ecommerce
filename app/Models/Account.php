<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name_ar', 'name_en', 'code', 'account_type', 'status', 'parent_id', 'reference_id', 'type', 'created_by', 'updated_by', 'dep_rate', 'branch_id'
    ];

    public function childrenRecursive()
    {
        return $this->accounts()->with('childrenRecursive');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function scopeWhenParent($query, $parent)
    {
        if ($parent == null) {
            return $query->when(function ($q) {
                return $q->whereNull('parent_id');
            });
        } else {
            return $query->when($parent, function ($q) use ($parent) {
                return $q->where('parent_id', 'like', "$parent");
            });
        }
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
            return $q->where('name_en', 'like', "%$search%")
                ->orWhere('name_ar', 'like', "%$search%")
                ->orWhere('code', 'like', "$search")
                ->orWhere('account_type', 'like', "%$search%");
        });
    }


    public function scopeWhenSearchExact($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('id', 'like', "$search");
        });
    }
}
