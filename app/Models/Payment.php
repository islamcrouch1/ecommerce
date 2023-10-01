<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = [
        'order_id', 'user_id', 'branch_id', 'from_account', 'to_account', 'type', 'amount', 'created_by', 'updated_by', 'invoice_id', 'currency_id'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function from()
    {
        return $this->belongsTo(Account::class, 'from_account');
    }

    public function to()
    {
        return $this->belongsTo(Account::class, 'to_account');
    }
}
