<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name_ar', 'name_en', 'code', 'account_type', 'status', 'parent_id', 'reference_id', 'type', 'created_by', 'updated_by', 'dep_rate', 'branch_id', 'currency_id'
    ];


    public function delete()
    {
        $this->users()->detach();
        return parent::delete();
    }

    public function childrenRecursive()
    {
        return $this->accounts()->with('childrenRecursive');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function scopeWhenParent($query, $parent, $account_id = null)
    {
        if ($parent == null) {
            if ($account_id == null) {
                return $query->when(function ($q) {
                    return $q->whereNull('parent_id');
                });
            }
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


    public function scopeWhenAccount($query, $account_id)
    {
        return $query->when($account_id, function ($q) use ($account_id) {
            return $q->where('id', 'like', "$account_id");
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


    public static function geAccounts($data = null)
    {


        $data = (object) $data;

        $user = Auth::user();
        $branches = getUserBranches($user);

        $accounts = self::select('id', 'name_ar', 'name_en', 'code', 'account_type', 'branch_id', 'created_at')
            // ->whereDate('created_at', '>=', $data->from ?? null)
            // ->whereDate('created_at', '<=', $data->to ?? null)
            ->whereIn('branch_id', $branches->pluck('id')->toArray())->whenSearch($data->search ?? null)
            ->whenBranch($data->branch_id ?? null)
            ->whenParent($data->parent_id ?? null, $data->account_id ?? null)
            ->whenAccount($data->account_id ?? null)
            ->get()
            ->toArray();


        $description_ar =  'تم تنزيل شيت شجرة الحسابات';
        $description_en  = 'Accounts file has been downloaded ';
        addLog('admin', 'exports', $description_ar, $description_en);

        return $accounts;
    }
}
