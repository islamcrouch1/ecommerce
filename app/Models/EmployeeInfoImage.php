<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInfoImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_info_id', 'media_id',
    ];

    public function employee_info()
    {
        return $this->belongsTo(EmployeeInfo::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
