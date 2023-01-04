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
        'code', 'name_ar', 'name_en', 'address', 'phone', 'email', 'country_id', 'status', 'is_default', 'created_by', 'updated_by'
    ];


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('code', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%");
        });
    }
}
