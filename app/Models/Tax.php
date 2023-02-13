<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tax extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name', 'description', 'tax_rate', 'created_by', 'updated_by',
    ];


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('tax_rate', 'like', "$search")
                ->orWhere('created_by', 'like', "%$search%");
        });
    }
}
