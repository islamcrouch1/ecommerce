<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Warehouse extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code', 'name_ar', 'name_en', 'address', 'phone', 'email', 'country_id', 'status', 'is_default', 'created_by', 'updated_by', 'vendor_id', 'branch_id', 'city_id'
    ];


    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }


    public function scopeWhenBranch($query, $branch_id)
    {
        return $query->when($branch_id, function ($q) use ($branch_id) {
            return $q->where('branch_id', 'like', "%$branch_id%");
        });
    }

    public function scopeWhenCity($query, $city_id)
    {
        return $query->when($city_id, function ($q) use ($city_id) {
            return $q->where('city_id', 'like', "%$city_id%");
        });
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('code', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%");
        });
    }
}
