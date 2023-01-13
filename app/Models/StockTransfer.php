<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no', 'notes', 'warehouse_from', 'warehouse_to', 'created_by', 'updated_by',
    ];

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->orWhere('reference_no', 'like', "%$search%")
                ->orWhere('warehouse_from', 'like', "$search")
                ->orWhere('warehouse_to', 'like', "$search")
                ->orWhere('notes', 'like', "%$search%");
        });
    }
}
