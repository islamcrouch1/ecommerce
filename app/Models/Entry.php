<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id', 'reference_id', 'type', 'warehouse_id', 'dr_amount', 'cr_amount', 'description', 'created_by', 'updated_by', 'created_at', 'branch_id', 'media_id', 'doc_num', 'due_date', 'currency_id', 'rate', 'foreign_currency_id', 'amount_in_foreign_currency'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function foreign_currency()
    {
        return $this->belongsTo(Currency::class, 'foreign_currency_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function scopeWhenAccount($query, $account_id)
    {
        return $query->when($account_id, function ($q) use ($account_id) {
            return $q->where('account_id', 'like', "$account_id");
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
            return $q->where('description', 'like', "%$search%")
                ->orWhere('type', 'like', "%$search%")
                ->orWhere('dr_amount', 'like', "%$search%")
                ->orWhere('cr_amount', 'like', "%$search%")
                ->orWhere('account_id', 'like', "$search")
                ->orWhere('branch_id', 'like', "$search")
                ->orWhere('doc_num', 'like', "$search");
        });
    }
}
