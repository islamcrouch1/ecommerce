<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'penalties', 'insurance', 'loans', 'rewards', 'basic_salary', 'variable_salary', 'day_salary', 'total_absence', 'total_deduction', 'net_salary', 'absence_days', 'status', 'date', 'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
