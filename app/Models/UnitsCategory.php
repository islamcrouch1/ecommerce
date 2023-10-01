<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UnitsCategory extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name_ar', 'name_en',
    ];


    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_ar', 'like', "%$search%");
        });
    }
}
