<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name_en', 'name_ar', 'media_id', 'description_ar', 'description_en', 'country_id', 'parent_id', 'profit', 'created_by', 'updated_by', 'category_slug', 'sort_order', 'subtitle_en', 'subtitle_ar', 'vendor_profit', 'category_id', 'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function main_products()
    {
        return $this->hasMany(Product::class);
    }


    // public function categories()
    // {
    //     return Category::where('parent_id', $this->id)->get();
    // }


    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "%$search%");
        });
    }

    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "%$country_id%");
        });
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
}
