<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;


    protected $fillable = [
        'name_ar', 'name_en', 'type', 'data', 'score', 'stage_id', 'is_required',
    ];




    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "$search");
        });
    }
}
