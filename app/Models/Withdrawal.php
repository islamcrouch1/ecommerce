<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'data', 'amount', 'code', 'status', 'country_id', 'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->Where('user_name', 'like', "%$search%");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "%$country_id%");
        });
    }

    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            return $q->where('status', 'like', "%$status%");
        });
    }

    public static function getWithdrawal($status = null, $from = null, $to = null)
    {

        $orders = DB::table('withdrawals')->select('id', 'user_id', 'data', 'amount', 'status', 'created_at')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get()->toArray();

        foreach ($orders as $index => $order) {

            $withdrawal = Withdrawal::where('id', $order->id)->first();
            $user = $withdrawal->user;
            $orders[$index]->name = $user->name;

            if ($user->HasRole('affiliate')) {
                $orders[$index]->type = 'Affiliate';
            } else {
                $orders[$index]->type = 'Vendor';
            }
        }

        if ($status != null) {
            if ($orders[$index]->status != $status) {

                unset($orders[$index]);
            }
        }

        $description_ar =  'تم تنزيل شيت طلبات سحب الرصيد';
        $description_en  = 'Withdrawals file has been downloaded ';
        addLog('admin', 'exports', $description_ar, $description_en);

        return $orders;
    }
}
