<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Media extends Model
{

    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name', 'extension', 'path', 'height', 'width', 'created_by', 'updated_by'
    ];

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }


    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    public function productCombinations()
    {
        return $this->hasMany(ProductCombination::class);
    }

    public function slides()
    {
        return $this->hasMany(Slide::class);
    }

    public function websiteOptions()
    {
        return $this->hasMany(WebsiteOption::class);
    }

    public function websiteSettings()
    {
        return $this->hasMany(WebsiteSetting::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name', 'like', "%$search%");
        });
    }
}
