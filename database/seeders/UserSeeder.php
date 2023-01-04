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
            'name' => '500.jpg',
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





        $media = Media::create([
            'created_by' => 1,
            'name' => '9.jpg',
            'extension' => 'image/jpeg',
            'height' => '525',
            'width' => '526',
            'path' => 'storage/images/categories/9.jpg',
        ]);

        $media = Media::create([
            'created_by' => 1,
            'name' => '10.jpg',
            'extension' => 'image/jpeg',
            'height' => '525',
            'width' => '526',
            'path' => 'storage/images/categories/10.jpg',
        ]);

        $media = Media::create([
            'created_by' => 1,
            'name' => '11.jpg',
            'extension' => 'image/jpeg',
            'height' => '525',
            'width' => '526',
            'path' => 'storage/images/categories/11.jpg',
        ]);

        $media = Media::create([
            'created_by' => 1,
            'name' => '12.jpg',
            'extension' => 'image/jpeg',
            'height' => '525',
            'width' => '526',
            'path' => 'storage/images/categories/12.jpg',
        ]);


        $media = Media::create([
            'created_by' => 1,
            'name' => '13.jpg',
            'extension' => 'image/jpeg',
            'height' => '525',
            'width' => '526',
            'path' => 'storage/images/categories/13.jpg',
        ]);

        $media = Media::create([
            'created_by' => 1,
            'name' => '14.jpg',
            'extension' => 'image/jpeg',
            'height' => '525',
            'width' => '526',
            'path' => 'storage/images/categories/14.jpg',
        ]);


        $category = Category::create([
            'name_ar' => 'ملابس',
            'name_en' => 'clothes',
            'description_ar' => 'ملابس',
            'description_en' => 'clothes',
            'media_id' => 1,
            'country_id' => 1,
            'profit' => 10,
            'category_slug' => 'clothes',
            'sort_order' => 1,
            'created_by' => 1,
            'subtitle_ar' => 'وفر 30 %',
            'subtitle_en' => 'save 30 %',


        ]);


        $category = Category::create([
            'name_ar' => 'احذية',
            'name_en' => 'shoases',
            'description_ar' => 'shoases',
            'description_en' => 'shoases',
            'media_id' => 2,
            'country_id' => 1,
            'profit' => 10,
            'category_slug' => 'clothes',
            'sort_order' => 1,
            'created_by' => 1,
            'subtitle_ar' => 'وفر 30 %',
            'subtitle_en' => 'save 30 %',

        ]);

        $category = Category::create([
            'name_ar' => '1ملابس',
            'name_en' => 'clothes1',
            'description_ar' => '1ملابس',
            'description_en' => 'clothes1',
            'media_id' => 3,
            'country_id' => 1,
            'profit' => 10,
            'category_slug' => 'clothes1',
            'sort_order' => 1,
            'created_by' => 1,
            'subtitle_ar' => 'وفر 30 %',
            'subtitle_en' => 'save 30 %',

        ]);


        $category = Category::create([
            'name_ar' => '12ملابس',
            'name_en' => 'clothes12',
            'description_ar' => '12ملابس',
            'description_en' => 'clothes12',
            'media_id' => 4,
            'country_id' => 1,
            'profit' => 10,
            'category_slug' => 'clothes12',
            'sort_order' => 1,
            'created_by' => 1,
            'subtitle_ar' => 'وفر 30 %',
            'subtitle_en' => 'save 30 %',

        ]);

        $category = Category::create([
            'name_ar' => '712ملابس',
            'name_en' => 'clothes12',
            'description_ar' => '12ملابس',
            'description_en' => 'clothes12',
            'media_id' => 5,
            'country_id' => 1,
            'profit' => 10,
            'category_slug' => 'clothes1287',
            'sort_order' => 1,
            'created_by' => 1,
            'subtitle_ar' => 'وفر 30 %',
            'subtitle_en' => 'save 30 %',

        ]);

        $category = Category::create([
            'name_ar' => '812ملابس',
            'name_en' => 'clothes128',
            'description_ar' => '812ملابس',
            'description_en' => 'clothes128',
            'media_id' => 6,
            'country_id' => 1,
            'profit' => 10,
            'category_slug' => 'clothes128',
            'sort_order' => 1,
            'created_by' => 1,
            'subtitle_ar' => 'وفر 30 %',
            'subtitle_en' => 'save 30 %',

        ]);

        $category = Category::create([
            'name_ar' => '11ملابس',
            'name_en' => 'clothes11',
            'description_ar' => '11ملابس',
            'description_en' => 'clothes11',
            'media_id' => 1,
            'country_id' => 1,
            'profit' => 10,
            'category_slug' => 'clothes11',
            'sort_order' => 1,
            'created_by' => 1,
            'parent_id' => 1,
            'subtitle_ar' => 'وفر 30 %',
            'subtitle_en' => 'save 30 %',
        ]);

        $category = Category::create([
            'name_ar' => '111ملابس',
            'name_en' => 'clothes111',
            'description_ar' => '111ملابس',
            'description_en' => 'clothes111',
            'media_id' => 1,
            'country_id' => 1,
            'profit' => 10,
            'category_slug' => 'clothes111',
            'sort_order' => 1,
            'created_by' => 1,
            'parent_id' => 7,
            'subtitle_ar' => 'وفر 30 %',
            'subtitle_en' => 'save 30 %',

        ]);

        $media = Media::create([
            'created_by' => 1,
            'name' => '1.jpg',
            'extension' => 'image/jpeg',
            'height' => '525',
            'width' => '526',
            'path' => 'storage/images/categories/1.jpg',
        ]);


        $brand = Brand::create([
            'name_ar' => 'اديداس',
            'name_en' => 'adidas',
            'media_id' => '2',
            'country_id' => '1',
            'brand_slug' => 'adidas',
            'sort_order' => '1',
            'created_by' => '1',
            'status' => 'active',
        ]);

        $brand = Brand::create([
            'name_ar' => '1اديداس',
            'name_en' => 'adidas1',
            'media_id' => '2',
            'country_id' => '1',
            'brand_slug' => 'adidas1',
            'sort_order' => '2',
            'created_by' => '1',
            'status' => 'active',
        ]);

        $brand = Brand::create([
            'name_ar' => '12اديداس',
            'name_en' => 'adidas12',
            'media_id' => '2',
            'country_id' => '1',
            'brand_slug' => 'adidas12',
            'sort_order' => '2',
            'created_by' => '1',
            'status' => 'active',
        ]);

        $attribute = Attribute::create([
            'name_ar' => 'الوان',
            'name_en' => 'colors',
        ]);

        $attribute = Attribute::create([
            'name_ar' => 'مقاسات',
            'name_en' => 'sizes',
        ]);

        $attribute = Attribute::create([
            'name_ar' => 'الرامات',
            'name_en' => 'RAM',
        ]);

        $variation = Variation::create([
            'name_ar' => 'احمر',
            'name_en' => 'red',
            'attribute_id' => 1,
            'value' => '#e34f34',
        ]);

        $variation = Variation::create([
            'name_ar' => 'اسود',
            'name_en' => 'black',
            'attribute_id' => 1,
            'value' => '#000000',
        ]);

        $variation = Variation::create([
            'name_ar' => 'ابيض',
            'name_en' => 'wight',
            'attribute_id' => 1,
            'value' => '#ffffff',
        ]);


        $variation = Variation::create([
            'name_ar' => 'XL',
            'name_en' => 'XL',
            'attribute_id' => 2,
            'value' => null,
        ]);

        $variation = Variation::create([
            'name_ar' => 'L',
            'name_en' => 'L',
            'attribute_id' => 2,
            'value' => null,
        ]);

        $variation = Variation::create([
            'name_ar' => '2G',
            'name_en' => '2G',
            'attribute_id' => 3,
            'value' => null,
        ]);

        $variation = Variation::create([
            'name_ar' => '4G',
            'name_en' => '4G',
            'attribute_id' => 3,
            'value' => null,
        ]);


        $warehouse = Warehouse::create([
            'name_ar' => 'مخزن فيصل',
            'name_en' => 'faisal warehouse',
            'code' => '002145',
            'address' => '9 شارع فيصل ارئيسي',
            'country_id' => 1,
            'created_by' => 1
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
