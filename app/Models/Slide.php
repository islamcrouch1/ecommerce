<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'slider_id', 'url', 'media_id', 'sort_order', 'text_1_ar', 'text_1_ar', 'text_1_en', 'text_2_ar', 'text_2_en', 'button_text_ar', 'button_text_en'
    ];


    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('slide_id', 'like', "%$search%")
                ->orWhere('url', 'like', "%$search%");
        });
    }
}
