<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Balance;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Country;
use App\Models\Media;
use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\User;
use App\Models\Variation;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {









        $user = User::create([
            'name' => 'superAdmin',
            'email' => 'admin@sonoo.online',
            'password' => bcrypt('123456789'),
            'phone' => '+201121184147',
            'country_id' => '1',
            'gender' => 'male',
            'profile' => 'avatarmale.png',
            'phone_verified_at' => '2021-10-25 22:43:41',
        ]);

        $user->attachRole('superadministrator');

        Cart::create([
            'user_id' => $user->id,
        ]);

        Balance::create([
            'user_id' => $user->id,
            'available_balance' => 0,
            'outstanding_balance' => 0,
            'pending_withdrawal_requests' => 0,
            'completed_withdrawal_requests' => 0,
            'bonus' => $user->hasRole('affiliate') ?  100 : 0,
        ]);


        $media = Media::create([
            'created_by' => 1,
            'name' => '9.jpg',
            'extension' => 'image/jpeg',
            'height' => '525',
            'width' => '526',
            'path' => 'storage/images/categories/9.jpg',
        ]);


        $country = Country::create([
            'name_ar' => 'مصر',
            'name_en' => 'Egypt',
            'code' => '+20',
            'currency' => 'EGP',
            'media_id' => $media->id,
            'is_default' => '1'
        ]);

        Setting::create([
            'type' => 'tax',
            'value' => '14',
        ]);

        Setting::create([
            'type' => 'compression_ratio',
            'value' => '80',
        ]);


        ShippingMethod::insertOrIgnore([
            [
                'name_ar' => 'الشحن بالوزن',
                'name_en' => 'shippingByWeight',
                'is_default' => '0',
                'shipping_amount' => 0,
                'status' => 1,
                'country_id' => getDefaultCountry()->id
            ],
            [
                'name_ar' => 'استلام من الفرع',
                'name_en' => 'localPickup',
                'is_default' => '0',
                'shipping_amount' => 0,
                'status' => 1,
                'country_id' => getDefaultCountry()->id

            ],
            [
                'name_ar' => 'شحن مجاني',
                'name_en' => 'freeShipping',
                'is_default' => '0',
                'shipping_amount' => 0,
                'status' => 1,
                'country_id' => getDefaultCountry()->id

            ],
            [
                'name_ar' => 'شحن ثابت للدولة',
                'name_en' => 'shipmentWithCountry',
                'is_default' => '0',
                'shipping_amount' => 0,
                'status' => 1,
                'country_id' => getDefaultCountry()->id

            ],
            [
                'name_ar' => 'شحن على حسب المحافظة',
                'name_en' => 'shipmentWithState',
                'is_default' => '0',
                'shipping_amount' => 0,
                'status' => 1,
                'country_id' => getDefaultCountry()->id

            ],

            [
                'name_ar' => 'شحن على حسب المنطقة',
                'name_en' => 'shipmentWithCity',
                'is_default' => '1',
                'shipping_amount' => 0,
                'status' => 1,
                'country_id' => getDefaultCountry()->id

            ],
        ]);
    }
}
