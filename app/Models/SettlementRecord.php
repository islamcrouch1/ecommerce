<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettlementRecord extends Model
{
    use HasFactory;


    protected $fillable = [
        'settlement_sheet_id', 'statement', 'amount', 'media_id',  'notes'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function sheet()
    {
        return $this->belongsTo(SettlementSheet::class, 'settlement_sheet_id');
    }
}
