<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'value_ar', 'media_id', 'description_ar', 'value_en', 'description_en'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
