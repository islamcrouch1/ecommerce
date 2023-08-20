<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInfo extends Model
{
    use HasFactory;


    protected $fillable = [
        'basic_salary', 'variable_salary', 'national_id', 'work_hours',  'name', 'address', 'job_title', 'branch_id', 'user_id', 'phone', 'Weekend_days', 'start_time',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function images()
    {
        return $this->hasMany(EmployeeInfoImage::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeWhenBranch($query, $branch_id)
    {
        return $query->when($branch_id, function ($q) use ($branch_id) {
            return $q->where('branch_id', 'like', "%$branch_id%");
        });
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('basic_salary', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('address', 'like', "$search")
                ->orWhere('job_title', 'like', "$search")
                ->orWhere('phone', 'like', "$search")
                ->orWhere('variable_salary', 'like', "$search")
                ->orWhere('national_id', 'like', "$search");
        });
    }
}
