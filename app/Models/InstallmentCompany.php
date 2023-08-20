<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class InstallmentCompany extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name_ar', 'name_en', 'type', 'admin_expenses', 'amount', 'months', 'media_id'
    ];

    public function delete()
    {
        $this->products()->detach();
        return parent::delete();
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "$search");
        });
    }
}
