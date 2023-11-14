<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name_ar', 'name_en', 'url', 'sort_order', 'media_id', 'website_category_id', 'description_en', 'description_ar', 'seo_meta_tag', 'seo_desc'
    ];

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function website_category()
    {
        return $this->belongsTo(WebsiteCategory::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "%$search%")
                ->orWhere('description_ar', 'like', "%$search%")
                ->orWhere('description_en', 'like', "%$search%");
        });
    }
}
