<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Balance;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Media;
use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\State;
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


        // $media = Media::create([
        //     'created_by' => 1,
        //     'name' => 'kuwait-flag.jpg',
        //     'extension' => 'image/jpeg',
        //     'height' => '853',
        //     'width' => '1280',
        //     'path' => 'storage/images/countries/kuwait-flag.jpg',
        // ]);


        // $country = Country::create([
        //     'name_ar' => 'الكويت',
        //     'name_en' => 'Kuwait',
        //     'code' => '+965',
        //     'currency' => 'KWD',
        //     'media_id' => $media->id,
        //     'is_default' => '0',
        //     'shipping_amount' => 1.5,
        // ]);


        // $states_ar = ['الكويت العاصمة', 'الجهراء', 'حولي', 'الفروانية', 'مبارك الكبير', 'الأحمدي'];
        // $states_en = ['Kuwait City', 'JAHRAA', 'Hawally', 'Al Farwaniyah', 'Mubarak Al-Kabeer', 'AHMADI'];

        // foreach ($states_ar as $index => $state) {

        //     $s = State::create([
        //         'name_ar' => $state,
        //         'name_en' => $states_en[$index],
        //         'country_id' => $country->id,
        //         'shipping_amount' => 1.5,
        //     ]);

        //     if ($index == 0) {
        //         $city_ar = ['ضاحية عبد الله السالم', 'العديلية', 'بنيد القار', 'الدعية', 'الدسمة', 'الدوحة', 'ميناء الدوحة', 'الفيحاء', 'فيلكا', 'غرناطة', 'جابر الأحمد', 'جِبْلَة', 'كيفان', 'الخالدية', 'المنصورية', 'المرقاب', 'النهضة', 'شمال غرب الصليبيخات', 'النزهة', 'القادسية', 'قرطبة', 'الروضة', 'الشامية', 'شرق', 'الشويخ', 'الشويخ الصناعية', 'ميناء الشويخ', 'الصليبخات', 'السرة', 'جزيرة ام النمل', 'اليرموك'];
        //         $city_en = ['Abdulla Al-Salem', 'Adailiya', 'Bnaid Al-Qar', 'Daʿiya', 'Dasma', 'Doha', 'Doha Port', 'Faiha', 'Failaka', 'Granada', 'Jaber Al-Ahmad', 'Jibla', 'Kaifan', 'Khaldiya', 'Mansūriya', 'Mirgab', 'Nahdha', 'North West Sulaibikhat', 'Nuzha', 'Qadsiya', 'Qurtuba', 'Rawda', 'Shamiya', 'Sharq', 'Shuwaikh', 'Shuwaikh Industrial Area', 'Shuwaikh Port', 'Sulaibikhat', 'Surra', 'Umm an Namil Island', 'Yarmouk'];
        //     }

        //     if ($index == 1) {
        //         $city_ar = ['العبدلي', 'النهضة / شرق الصليبخات', 'أمغرة', 'بر الجهراء', 'الجهراء', 'الجهراء المنطقة الصناعية', 'كبد', 'النعيم', 'النسيم', 'العيون', 'القصر', 'مدينة سعد العبدالله', 'السالمي', 'السكراب', 'جنوب الدوحة / القيروان', 'الصبية', 'الصليبية', 'الصليبية المنطقة الزراعية', 'تيماء', 'الواحة'];
        //         $city_en = ['Abdali', 'Al Nahda / East Sulaibikhat', 'Amghara', 'Bar Jahra', 'Jahra', 'Jahra Industrial Area', 'Kabad', 'Naeem', 'Nasseem', 'Oyoun', 'Qasr', 'Saad Al Abdullah City', 'Salmi', 'Sikrab', 'South Doha / Qairawān', 'Subiya', 'Sulaibiya', 'Sulaibiya Agricultural Area', 'Taima', 'Waha'];
        //     }

        //     if ($index == 2) {
        //         $city_ar = ['أنجفة', 'بيان', 'البدع', 'حولي', 'حطين', 'الجابرية', 'ميدان حولي', 'مشرف', 'مبارك الجابر', 'النقرة', 'الرميثية', 'سلام', 'السالمية', 'سلوى', 'الشعب', 'الشهداء', 'الصديق', 'جنوب السرة	', 'الزهراء'];
        //         $city_en = ['Anjafa', 'Bayān', 'Bida', 'Hawally', 'Hittin', 'Jabriya', 'Maidan Hawalli', 'Mishrif', 'Mubarak Al-Jabir', 'Nigra', 'Rumaithiya', 'Salam', 'Salmiya', 'Salwa', 'Shaab', 'Shuhada', 'Siddiq', 'South Surra', 'Zahra'];
        //     }

        //     if ($index == 3) {
        //         $city_ar = ['عبدالله المبارك', 'منطقة المطار', 'الأندلس', 'العارضية', 'العارضية حرفية', 'العارضية المنطقة الصناعية', 'اشبيلية', 'الضجيج', 'الفروانية', 'الفردوس', 'جليب الشيوخ', 'خيطان', 'العمرية', 'الرابية', 'الري', 'الرقعي', 'الرحاب', 'صباح الناصر', 'سباق الهجن'];
        //         $city_en = ['Abdullah Al-Mubarak', 'Airport District', 'Andalous', 'Ardiya', 'Ardiya Herafiya', 'Ardiya Industrial Area', 'Ashbelya', 'Dhajeej', 'Farwaniya', 'Fordous', 'Jleeb Al-Shuyoukh', 'Khaitan', 'Omariya', 'Rabiya', 'Rai', 'Al-Riggae', 'Rihab', 'Sabah Al-Nasser', 'Sabaq Al Hajan'];
        //     }

        //     if ($index == 4) {
        //         $city_ar = ['أبو الحصانية', 'أبو فطيرة', 'العدان', 'القرين', 'القصور', 'الفنطاس', 'الفنيطيس', 'المسيلة', 'مبارك الكبير', 'صباح السالم', 'صبحان', 'جنوب وسطي', 'وسطي'];
        //         $city_en = ['Abu Al Hasaniya', 'Abu Futaira', 'Adān', 'Al Qurain', 'Al-Qusour', 'Fintās', 'Funaitīs', 'Misīla', 'Mubarak Al-Kabeer', 'Sabah Al-Salem', 'Sabhān', 'South Wista', 'Wista'];
        //     }

        //     if ($index == 5) {
        //         $city_ar = ['أبو حليفة', 'ميناء عبد الله', 'الأحمدي', 'علي صباح السالم', 'العقيلة', 'بر الأحمدي', 'بنيدر', 'الظهر', 'الفحيحيل', 'فهد الأحمد', 'هدية', 'جابر العلي', 'جواخير الوفرة', 'الجليعة', 'الخيران', 'المهبولة', 'المنقف', 'المقوع', 'مدينة الخيران الجديدة', 'الوفرة الجديدة', 'النويصيب', 'الرقة', 'مدينة صباح الأحمد', 'مدينة صباح الأحمد البحرية', 'الصباحية', 'الشعيبة', 'جنوب الصباحية', 'الوفرة', 'الزور', 'الظهر'];
        //         $city_en = ['Abu Halifa', 'Abdullah Port', 'Ahmadi', 'Ali As-Salim', 'Aqila', 'Bar Al Ahmadi', 'Bneidar', 'Dhaher', 'Fahaheel', 'Fahad Al-Ahmad', 'Hadiya', 'Jaber Al-Ali', 'Jawaher Al Wafra', 'Jileia', 'Khairan', 'Mahbula', 'Mangaf', 'Miqwa', 'New Khairan City', 'New Wafra', 'Nuwaiseeb', 'Riqqa', 'Sabah Al-Ahmad City', 'Sabah Al Ahmad Sea City', 'Sabahiya', 'Shuaiba', 'South Sabahiya', 'Wafra', 'Zoor', 'Zuhar'];
        //     }

        //     foreach ($city_ar as $index => $city) {
        //         $c = City::create([
        //             'name_ar' => $city,
        //             'name_en' => $city_en[$index],
        //             'country_id' => $country->id,
        //             'state_id' => $s->id,
        //             'shipping_amount' => 1.5,
        //         ]);
        //     }
        // }







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
