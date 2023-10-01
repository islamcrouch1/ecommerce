<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomComponent extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_id', 'product_combination_id', 'bom_id', 'qty', 'unit_id'
    ];
}
