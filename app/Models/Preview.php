<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Preview extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'total_score', 'user_id', 'created_by', 'updated_by', 'stage_count',
    ];

    public function fields()
    {
        return $this->belongsToMany(Field::class)->withPivot('stage_id', 'score', 'type', 'data', 'media_id');
    }


    public function stages()
    {
        return $this->belongsToMany(Stage::class)->withPivot('score');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('total_score', 'like', "%$search%")
                ->orWhere('user_id', 'like', "$search");
        });
    }
}
