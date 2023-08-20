<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name', 'email', 'password', 'country_id', 'phone', 'gender', 'profile', 'role', 'status', 'lang', 'store_name', 'store_description', 'store_profile', 'store_cover', 'store_status', 'created_by', 'updated_by', 'branch_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public function delete()
    {
        $this->accounts()->detach();
        return parent::delete();
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }

    public function store_products()
    {
        return $this->hasMany(StoreProduct::class);
    }

    public function vendor_products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }




    public function warehouses()
    {
        return $this->hasMany(Warehouse::class, 'vendor_id');
    }

    public function cart_items()
    {
        return $this->hasMany(CartItem::class);
    }


    public function salary_card()
    {
        return $this->hasMany(SalaryCard::class);
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }


    public function previews()
    {
        return $this->hasMany(Preview::class);
    }




    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function fav()
    {
        return $this->hasMany(Favorite::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }




    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function order_notes()
    {
        return $this->hasMany(OrderNote::class);
    }


    public function vendor_orders()
    {
        return $this->hasMany(VendorOrder::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function info()
    {
        return $this->hasMany(UserInfo::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function sheets()
    {
        return $this->hasMany(SettlementSheet::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('phone', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('id', 'like', "$search");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "%$country_id%");
        });
    }


    public function scopeWhenBranch($query, $branch_id)
    {
        return $query->when($branch_id, function ($q) use ($branch_id) {
            return $q->where('branch_id', 'like', "%$branch_id%");
        });
    }

    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            if ($status == 'active' || $status == 'inactive') {
                return $status == 'active' ? $q->whereNotNull('phone_verified_at') : $q->whereNull('phone_verified_at');
            } else {
                return $q->where('status', 'like', $status);
            }
        });
    }

    public function scopeWhenRole($query, $role_id)
    {
        return $query->when($role_id, function ($q) use ($role_id) {
            return $this->scopeWhereRole($q, $role_id);
        });
    }

    public function scopeWhereRole($query, $role_name)
    {
        return $query->whereHas('roles', function ($q) use ($role_name) {
            return $q->whereIn('name', (array)$role_name)
                ->orWhereIn('id', (array)$role_name);
        });
    }

    public function scopeWhereRoleNot($query, $role_name)
    {
        return $query->whereHas('roles', function ($q) use ($role_name) {
            return $q->whereNotIn('name', (array)$role_name)
                ->WhereNotIn('id', (array)$role_name);
        });
    }


    public static function getUsers($data = null)
    {


        $data = (object) $data;


        $users = self::select('id', 'name', 'phone', 'email', 'gender', 'created_at')
            ->whereDate('created_at', '>=', $data->from ?? null)
            ->whereDate('created_at', '<=', $data->to ?? null)
            ->whenSearch($data->search ?? null)
            ->whenRole($data->role_id ?? null)
            ->whenCountry($data->country_id ?? null)
            ->whenBranch($data->branch_id ?? null)
            ->whenStatus($data->status ?? null)
            ->whereRoleNot('superadministrator')
            ->get()
            ->toArray();




        foreach ($users as $index => $user) {
            $user = User::find($user['id']);
            $roles = $user->getRoles();
            $users[$index]['type'] = implode(",", $roles);;
        }



        $description_ar =  'تم تنزيل شيت المستخدمين';
        $description_en  = 'Users file has been downloaded ';
        addLog('admin', 'exports', $description_ar, $description_en);

        return $users;
    }
}
