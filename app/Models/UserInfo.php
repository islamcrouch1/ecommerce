<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;


    protected $fillable = [
        'store_name', 'store_description', 'store_profile', 'store_cover', 'commercial_record', 'tax_card', 'id_card_front', 'id_card_back', 'company_address', 'bank_account', 'website', 'facebook_page', 'store_status', 'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
