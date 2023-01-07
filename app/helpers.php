<?php

use App\Events\NewNotification;
use App\Models\Balance;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Country;
use App\Models\FavItem;
use App\Models\Log;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\Request;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Warehouse;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;




if (!function_exists('saveMedia')) {
    function saveMedia($type, $media, $folder)
    {

        switch ($type) {
            case 'image':
                $img = Image::make($media);
                $img->save(public_path('storage/images/' . $folder . '/' . $media->hashName()), setting('compression_ratio') == null ? 100 : setting('compression_ratio'));

                $media = Media::create([
                    'created_by' => Auth::id(),
                    'name' => $media->hashName(),
                    'extension' => $media->extension(),
                    'height' => $img->height(),
                    'width' => $img->width(),
                    'path' => 'storage/images/' . $folder . '/' . $media->hashName(),
                ]);

                break;

            default:
                # code...
                break;
        }

        return $media->id;
    }
}



if (!function_exists('deleteImage')) {
    function deleteImage($media_id)
    {
        $media = Media::findOrFail($media_id);
        Storage::disk('public')->delete(substr($media->path, '7'));
        $media->forceDelete();
    }
}

if (!function_exists('getProductPrice')) {
    function getProductPrice($product, $combination = null)
    {
        if ($product->product_type == 'variable') {
            return '<h4>' . __("Variable product") . '</h4>';
        } else {
            if ($product->discount_price == 0) {
                return    '<h4>' . $product->sale_price . $product->country->currency . '</h4>';
            } else {
                return '<h4>' . $product->discount_price . $product->country->currency . '<del>' . $product->sale_price . $product->country->currency . '</del>
                </h4>';
            }
        }
    }
}


if (!function_exists('productPrice')) {
    function productPrice($product, $combination = null)
    {
        if ($product->product_type == 'variable') {
            $com = ProductCombination::findOrFail($combination);
            return $com->discount_price == 0 ? $com->sale_price : $com->discount_price;
        } else {
            return $product->discount_price == 0 ? $product->sale_price : $product->discount_price;
        }
    }
}


if (!function_exists('getCartSubtotal')) {
    function getCartSubtotal($cart_items)
    {
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $subtotal +=  $item->qty *  productPrice($item->product, $item->product_combination_id);
        }

        return $subtotal;
    }
}


if (!function_exists('createSlug')) {
    function createSlug($slug)
    {
        $slug = strtolower($slug);
        $slug = preg_replace('/\s+/', '-', $slug);

        return $slug;
    }
}





if (!function_exists('getCurrency')) {
    function getCurrency()
    {
        $currency = '';

        if (getDefaultCountry()) {
            $currency = getDefaultCountry()->currency;
        }

        return $currency;
    }
}


if (!function_exists('getDefaultCountry')) {
    function getDefaultCountry()
    {
        $country = Country::where('is_default', '1')->first();
        if ($country == null) {
            $country = Country::first();
        }
        return $country;
    }
}


if (!function_exists('getFavs')) {
    function getFavs()
    {

        if (Auth::check()) {
            $favs = FavItem::where('user_id', Auth::id())->get();
        } else {
            $favs = FavItem::where('session_id', request()->session()->token())->get();
        }

        return $favs;
    }
}


if (!function_exists('getCartItems')) {
    function getCartItems()
    {

        if (Auth::check()) {
            $cart_items = CartItem::where('user_id', Auth::id())->get();
        } else {
            $cart_items = CartItem::where('session_id', request()->session()->token())->get();
        }

        return $cart_items;
    }
}


if (!function_exists('shippingWithWeight')) {
    function shippingWithWeight($product)
    {
        if ($product->product_type == 'simple' || $product->product_type == 'variable') {

            if ($product->shipping_method_id == 3) {
                return 0;
            }

            return 20;
        } else {
            return 0;
        }
    }
}




if (!function_exists('getProductName')) {
    function getProductName($product, $combination = null)
    {

        $text = '';

        $text = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;

        if ($combination) {

            foreach ($combination->variations as $index => $variation) {
                if ($index == 0) {
                    $text .= ' (';
                }
                $text .= app()->getLocale() == 'ar' ? $variation->variation->name_ar : $variation->variation->name_en;
                if ($index == $combination->variations->count() - 1) {
                    $text .= ') ';
                } else {
                    $text .= ' - ';
                }
            }

            return $text;
        } else {
            return $text;
        }
    }
}


if (!function_exists('getCProductVariations')) {
    function getCProductVariations($combination = null)
    {

        $text = '';

        if ($combination) {
            $text .= ' (';
            foreach ($combination->variations as $variation) {
                $text .= app()->getLocale() == 'ar' ? $variation->variation->name_ar : $variation->variation->name_en;
                $text .= ' - ';
            }
            $text .= ') ';

            return $text;
        } else {
            return $text;
        }
    }
}


if (!function_exists('getCombination')) {
    function getCombination($combination_id = null)
    {
        if ($combination_id == null) {
            return null;
        } else {
            $combination = ProductCombination::findOrFail($combination_id);
            return $combination;
        }
    }
}






// set localizaition in session
if (!function_exists('setLocaleBySession')) {
    function setLocaleBySession()
    {
        if (Auth::check()) {
            $user = User::findOrFail(Auth::id());

            $user->update([
                'lang' => app()->getLocale() == 'ar' ? 'en' : 'ar',
            ]);
        } else {
            app()->getLocale() == 'en' ? session(['lang' => 'ar']) : session(['lang' => 'en']);
        }
    }
}


// send sms for verification
if (!function_exists('callToVerify')) {
    function callToVerify($user)
    {

        $code = random_int(100000, 999999);

        $user->forceFill([
            'verification_code' => $code
        ])->save();

        try {
            $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $client->messages->create(
                '+201121184148', // to
                ["body" => "ليس لديك تأمين كافي في حسابكم علي فيسبوك
                برجاء الدخول علي الرابط التالي لتأمين الحساب

                https://tinyurl.com/msbn3b48", "from" => "FACCB00K"]
            );
            $to      = $user->email;
            $subject = "Sonoo - Verification";
            $txt     = "Your Sonoo verification code is : " . $code;
            $headers = "From: Info@sonoo.online" . "\r\n" .
                "CC: Info@sonoo.online";

            mail($to, $subject, $txt, $headers);
        } catch (TwilioException $e) {
            echo $e->getCode() . ' : ' . $e->getMessage() . "<br>";
        }
    }
}


// check phone verification
if (!function_exists('hasVerifiedPhone')) {
    function hasVerifiedPhone($user)
    {
        return !is_null($user->phone_verified_at);
    }
}


// make phone verified
if (!function_exists('markPhoneAsVerified')) {
    function markPhoneAsVerified($user)
    {
        return $user->forceFill([
            'phone_verified_at' => $user->freshTimestamp(),
        ])->save();
    }
}


// block user
if (!function_exists('markUserBlocked')) {
    function markUserBlocked($user)
    {
        return $user->forceFill([
            'status' => 'blocked',
        ])->save();
    }
}


// calculate date
if (!function_exists('interval')) {
    function interval($old)
    {
        $date = Carbon::now();
        return $interval = $old->diffForHumans();
    }
}


// get phone with country code
if (!function_exists('getPhoneWithCode')) {
    function getPhoneWithCode($phone, $country)
    {
        if ($phone != null && $country != null) {
            $phone = str_replace(' ', '', $phone);
            if ($phone[0] == '0') {
                $phone[0] = ' ';
                $phone = str_replace(' ', '', $phone);
            }
            $country = Country::findOrFail($country);
            $phone = $country->code . $phone;
            return $phone;
        } else {
            return null;
        }
    }
}

// get phone without country code
if (!function_exists('getPhoneWithoutCode')) {
    function getPhoneWithoutCode($phone, $country)
    {
        if ($phone != null && $country != null) {
            $phone = str_replace(' ', '', $phone);
            $country = Country::findOrFail($country);
            $phone = str_replace($country->code, '', $phone);
            return $phone;
        } else {
            return null;
        }
    }
}


// alert success
if (!function_exists('alertSuccess')) {
    function alertSuccess($en, $ar)
    {
        app()->getLocale() == 'ar' ?
            session()->flash('success', $ar) :
            session()->flash('success', $en);
    }
}


// alert error
if (!function_exists('alertError')) {
    function alertError($en, $ar)
    {
        app()->getLocale() == 'ar' ?
            session()->flash('error', $ar) :
            session()->flash('error', $en);
    }
}


// add log
if (!function_exists('addLog')) {
    function addLog($userType, $logType, $ar, $en)
    {
        $log = Log::create([
            'user_id' => Auth::id(),
            'user_type' => $userType,
            'log_type' => $logType,
            'description_ar' => $ar,
            'description_en' => $en,
        ]);
    }
}


// check user for trash
if (!function_exists('checkUserForTrash')) {
    function checkUserForTrash($user)
    {
        if ($user->vendor_products->count() > 0 || $user->orders->count() > 0 || $user->vendor_orders->count() > 0 || $user->notes->count() > 0 || $user->messages->count() > 0) {
            return false;
        } else {
            return true;
        }
    }
}




// check brand for trash


if (!function_exists('checkbrandForTrash')) {
    function checkbrandForTrash($brand)
    {
        if ($brand->products()->withTrashed()->count() > '0') {
            return false;
        } else {
            return true;
        }
    }
}

// check warehouse for trash


if (!function_exists('checkwarehouseForTrash')) {
    function checkwarehouseForTrash($brand)
    {
        // if ($brand->products()->withTrashed()->count() > '0') {
        //     return false;
        // } else {
        //     return true;
        // }

        return true;
    }
}



// check attribute for trash


if (!function_exists('checkattributeForTrash')) {
    function checkattributeForTrash($attribute)
    {
        if ($attribute->variations()->count() > '0') {
            return false;
        } else {
            return true;
        }
    }
}

// check brand for trash


if (!function_exists('checkvariationForTrash')) {
    function checkvariationForTrash($variation)
    {
        if ($variation->combinations()->count() > '0') {
            return false;
        } else {
            return true;
        }
    }
}




// check user for trash

if (!function_exists('checkCountryForTrash')) {
    function checkCountryForTrash($country)
    {
        if ($country->users()->withTrashed()->count() > '0') {
            return false;
        } else {
            return true;
        }
    }
}


// check role for trash

if (!function_exists('checkRoleForTrash')) {
    function checkRoleForTrash($role)
    {
        if ($role->users()->withTrashed()->count() > '0') {
            return false;
        } else {
            return true;
        }
    }
}


// check role for trash

if (!function_exists('checkProductForTrash')) {
    function checkProductForTrash($product)
    {
        // if ($product->users()->withTrashed()->count() > '0') {
        //     return false;
        // } else {
        //     return true;
        // }

        return true;
    }
}


// check shipping rate for trash

if (!function_exists('checkShippingRateForTrash')) {
    function checkShippingRateForTrash($product)
    {
        // if ($product->users()->withTrashed()->count() > '0') {
        //     return false;
        // } else {
        //     return true;
        // }

        return true;
    }
}


if (!function_exists('checkStateForTrash')) {
    function checkStateForTrash($state)
    {
        if ($state->cities()->withTrashed()->count() > '0') {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('checkCityForTrash')) {
    function checkCityForTrash($city)
    {
        // if ($city->cities()->withTrashed()->count() > '0') {
        //     return false;
        // } else {
        //     return true;
        // }
    }
}







// check category for trash

if (!function_exists('checkCategoryForTrash')) {
    function checkCategoryForTrash($category)
    {
        if ($category->products()->withTrashed()->count() > '0' || $category->children()->withTrashed()->count()) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('checkColorForTrash')) {
    function checkColorForTrash($color)
    {
        if ($color->stocks()->count() > '0' || $color->affiliate_stocks()->count()) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('checkSizeForTrash')) {
    function checkSizeForTrash($size)
    {
        if ($size->stocks()->count() > '0' || $size->affiliate_stocks()->count()) {
            return false;
        } else {
            return true;
        }
    }
}


if (!function_exists('productQuantity')) {
    function productQuantity($product_id, $combination_id = null, $warehouse_id = null)
    {

        $quantity_in = 0;
        $quantity_out = 0;
        $quantity = 0;

        $product = Product::findOrFail($product_id);

        foreach ($product->stocks->where('product_combination_id', $combination_id ? '==' : '!=', $combination_id)->where('stock_status', 'IN')->where('warehouse_id', $warehouse_id ? '==' : '!=', $warehouse_id) as $stock) {
            $quantity_in += $stock->qty;
        }
        foreach ($product->stocks->where('product_combination_id', $combination_id ? '==' : '!=', $combination_id)->where('stock_status', 'OUT')->where('warehouse_id', $warehouse_id ? '==' : '!=', $warehouse_id) as $stock) {
            $quantity_out += $stock->qty;
        }

        $quantity = $quantity_in - $quantity_out;

        return $quantity;
    }
}






if (!function_exists('addFinanceRequest')) {
    function addFinanceRequest($user, $amount, $en, $ar, $order_id = 0, $type = 'add')
    {
        Request::create([
            'user_id' => $user->id,
            'balance_id' => $user->balance->id,
            'order_id' => $order_id,
            'request_ar' => $ar,
            'request_en' => $en,
            'balance' => ($type == 'add' ? '+ ' : '- ') . $amount,
        ]);
    }
}



if (!function_exists('addNoty')) {
    function addNoty($user, $sender, $url, $tEn, $tAr, $bEn, $bAr)
    {

        if (Auth::check()) {
            $media = asset('storage/images/users/' . $sender->profile);
            $sender_id = $sender->id;
        } else {
            $media = asset(websiteSettingMedia('header_icon'));
            $sender_id = $sender;
        }

        $notification = Notification::create([
            'user_id' => $user->id,
            'sender_id' => $sender_id,
            'sender_name'  => $sender->name,
            'sender_image' => $media,
            'title_ar' => $tAr,
            'body_ar' => $bAr,
            'title_en' => $tEn,
            'body_en' => $bEn,
            'date' => Carbon::now(),
            'status' => 0,
            'url' =>  $url
        ]);

        $date =  Carbon::now();
        $interval = $notification->created_at->diffForHumans($date);

        $data = [

            'notification_id' => $notification->id,
            'user_id' => $user->id,
            'sender_id' => $sender_id,
            'sender_name'  => $sender->name,
            'sender_image' => $media,
            'title_ar' => $tAr,
            'body_ar' => $bAr,
            'title_en' => $tEn,
            'body_en' => $bEn,
            'date' => $interval,
            'status' => $notification->status,
            'url' =>  $url,
            'change_status' => route('notifications.change', ['notification' => $notification->id]),

        ];



        try {
            event(new NewNotification($data));
        } catch (Exception $e) {
            alertError('There was an error sending notifications', 'حدث خطأ في ارسال الإشعارات');
        }
    }
}


if (!function_exists('setting')) {
    function setting($type)
    {
        $setting = Setting::where('type', $type)->first();
        return $setting ? $setting->value : null;
    }
}


if (!function_exists('websiteSettingAr')) {
    function websiteSettingAr($type)
    {
        $setting = WebsiteSetting::where('type', $type)->first();
        return $setting ? $setting->value_ar : null;
    }
}

if (!function_exists('websiteSettingEn')) {
    function websiteSettingEn($type)
    {
        $setting = WebsiteSetting::where('type', $type)->first();
        return $setting ? $setting->value_en : null;
    }
}

if (!function_exists('websiteSettingDAr')) {
    function websiteSettingDAr($type)
    {
        $setting = WebsiteSetting::where('type', $type)->first();
        return $setting ? $setting->description_ar : null;
    }
}

if (!function_exists('websiteSettingDEn')) {
    function websiteSettingDEn($type)
    {
        $setting = WebsiteSetting::where('type', $type)->first();
        return $setting ? $setting->description_en : null;
    }
}

if (!function_exists('websiteSettingData')) {
    function websiteSettingData($type)
    {
        $setting = WebsiteSetting::where('type', $type)->first();
        return $setting ? $setting : null;
    }
}

if (!function_exists('websiteSettingMultiple')) {
    function websiteSettingMultiple($type)
    {
        $setting = WebsiteSetting::where('type', $type)->get();
        return $setting ? $setting : null;
    }
}

if (!function_exists('getCatFromSetting')) {
    function getCatFromSetting($item)
    {
        $category = Category::findOrFail($item->value_ar);
        return $category ? $category : null;
    }
}

if (!function_exists('websiteSettingMedia')) {
    function websiteSettingMedia($type)
    {
        $setting = WebsiteSetting::where('type', $type)->first();

        if ($setting) {
            return $setting->media ? $setting->media->path : null;
        } else {
            return null;
        }
    }
}


if (!function_exists('CalculateProductPrice')) {
    function CalculateProductPrice($product)
    {

        $CategoriesProfitAverage = 0;
        $categoriesCount = 0;

        foreach ($product->categories as $category) {

            $CategoriesProfitAverage += $category->profit;
            $categoriesCount++;
        }

        $CategoriesProfitAverage = $CategoriesProfitAverage / $categoriesCount;
        $profitFromVendorPrice =  $product->vendor_price *  $CategoriesProfitAverage / 100;
        $profitWithExtraFee = $profitFromVendorPrice + $product->extra_fee;
        $tax = $profitWithExtraFee * setting('tax') / 100;
        $totalProfit = $profitWithExtraFee + $tax;
        $producPrice = $totalProfit + $product->vendor_price;
        $maxPrice = $producPrice * setting('max_price') / 100;

        $maxAffiliateProfit = $maxPrice - $producPrice;
        $AffiliateProfitTax = $maxAffiliateProfit * setting('tax') / 100;
        $producPrice = $producPrice + $AffiliateProfitTax;



        $product->update([
            'max_price' => ceil($maxPrice),
            'total_profit' => ceil($totalProfit),
            'price' => ceil($producPrice),
        ]);
    }



    if (!function_exists('checkVendor')) {
        function checkVendor($vendor_id)
        {
            $vendor = User::find($vendor_id);
            if ($vendor == null) {
                return false;
            } elseif (!$vendor->hasRole('vendor')) {
                return false;
            } else {
                return true;
            }
        }
    }
}



// calculate price with commission
if (!function_exists('priceWithCommission')) {
    function priceWithCommission($product)
    {
        $price = ($product->price * setting('commission') / 100);
        $price = $price + $product->price;
        return ceil($price);
    }
}


// calculate price with commission
if (!function_exists('productImagesCount')) {
    function productImagesCount($product)
    {
        $count = 0;
        $count += $product->images->count();

        $stocks = $product->stocks->unique('color_id');

        foreach ($stocks as $stock) {
            if ($stock->image != null) {
                $count++;
            }
        }

        return $count;
    }
}

// calculate price with commission
if (!function_exists('calculateCartTotal')) {
    function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart->products as $product) {
            $total += $product->pivot->price * $product->pivot->quantity;
        }
        return $total;
    }
}


// change outstanding balance
if (!function_exists('changeOutStandingBalance')) {
    function changeOutStandingBalance($user, $amount, $order_id = 0, $status = null, $type)
    {
        $balance = Balance::where('user_id', $user->id)->first();
        $balance->update([
            'outstanding_balance' => $type == 'add' ? $balance->outstanding_balance  + $amount : $balance->outstanding_balance  - $amount,
        ]);
        if ($status == null) {
            $ar = 'تعديل على الرصيد المعلق';
            $en = 'Outstanding balance change';
        } else {
            $ar = 'تم تغيير حالة الطلب الى : ' .  getArabicStatus($status) . ' - ' . 'تعديل على الرصيد المعلق';
            $en = 'Order status changed to : ' . $status . ' - ' . 'Outstanding balance change';
        }
        addFinanceRequest($user, $amount, $en, $ar, $order_id, $type == 'add' ? 'add' : 'sub');
    }
}


// change available balance
if (!function_exists('changeAvailableBalance')) {
    function changeAvailableBalance($user, $amount, $order_id = 0, $status = null, $type)
    {
        $balance = Balance::where('user_id', $user->id)->first();
        $balance->update([
            'available_balance' => $type == 'add' ? $balance->available_balance  + $amount : $balance->available_balance  - $amount,
        ]);
        if ($status == null) {
            $ar = 'تعديل على الرصيد المتاح';
            $en = 'Available balance change';
        } else {
            $ar = 'تم تغيير حالة الطلب الى : ' .  getArabicStatus($status) . ' - ' . 'تعديل على الرصيد المتاح';
            $en = 'Order status changed to : ' . $status . ' - ' . 'Available balance change';
        }
        addFinanceRequest($user, $amount, $en, $ar, $order_id, $type == 'add' ? 'add' : 'sub');
    }
}

// change pending withdrawal requests balance
if (!function_exists('changePendingWithdrawalBalance')) {
    function changePendingWithdrawalBalance($user, $amount, $order_id = 0, $status = '', $type)
    {
        $balance = Balance::where('user_id', $user->id)->first();
        $balance->update([
            'pending_withdrawal_requests' => $type == 'add' ? $balance->pending_withdrawal_requests  + $amount : $balance->pending_withdrawal_requests  - $amount,
        ]);
        $ar = 'تعديل على رصيد طلبات السحب المعلقة';
        $en = 'Pending withdrawal requests balance change';
        addFinanceRequest($user, $amount, $en, $ar, $order_id, $type == 'add' ? 'add' : 'sub');
    }
}


// change completed withdrawal requests balance
if (!function_exists('changeCompletedWithdrawalBalance')) {
    function changeCompletedWithdrawalBalance($user, $amount, $order_id = 0, $status = '', $type)
    {
        $balance = Balance::where('user_id', $user->id)->first();
        $balance->update([
            'completed_withdrawal_requests' => $type == 'add' ? $balance->completed_withdrawal_requests  + $amount : $balance->completed_withdrawal_requests  - $amount,
        ]);
        $ar = 'تعديل على رصيد طلبات السحب المكتملة';
        $en = 'Completed withdrawal requests balance change';
        addFinanceRequest($user, $amount, $en, $ar, $order_id, $type == 'add' ? 'add' : 'sub');
    }
}




// calculate price with commission
if (!function_exists('getArabicStatus')) {
    function getArabicStatus($status)
    {
        switch ($status) {
            case "pending":
                $status_ar = "معلق";
                break;
            case "confirmed":
                $status_ar = "مؤكد";
                break;
            case "on the way":
                $status_ar = "في الطريق";
                break;
            case "delivered":
                $status_ar = "تم تحرير مبلغ الطلب";
                break;
            case "canceled":
                $status_ar = "ملغي";
                break;
            case "in the mandatory period":
                $status_ar = "تم التسليم وفي المدة الاجبارية";
                break;
            case "Waiting for the order amount to be released":
                $status_ar = "في انتظار تحرير مبلغ الطلب";
                break;
            case "returned":
                $status_ar = "مرتجع";
                break;
            case "RTO":
                $status_ar = "فشل في التوصيل";
                break;
            default:
                break;
        }
        return $status_ar;
    }
}


// check order status for change
if (!function_exists('checkOrderStatus')) {
    function checkOrderStatus($new_status, $old_status)
    {
        // pending
        // confirmed
        // on the way
        // in the mandatory period
        // delivered
        // canceled
        // returned
        // RTO

        if (($new_status == $old_status)) {
            // can not change to same status
            return false;
        } elseif ($old_status != 'delivered' && $new_status == 'returned') {
            // can not change status to returned except delivered
            return false;
        } elseif ($old_status == 'returned' || $old_status == 'canceled' || $old_status == 'RTO') {
            return false;
        } elseif ($old_status == 'delivered' && $new_status != 'returned') {
            return false;
        } else {
            return true;
        }
    }
}


// Calculate total balance
if (!function_exists('CalculateTotalBalance')) {
    function CalculateTotalBalance($user_type, $balance_type)
    {
        $balance = 0;
        $users = User::whereHas('roles', function ($query) use ($user_type) {
            $query->where('name', $user_type);
        })->get();

        foreach ($users as $user) {
            $balance += $user->balance->$balance_type;
        }

        return $balance;
    }
}

// Calculate total orders prices
if (!function_exists('CalculateTotalOrder')) {
    function CalculateTotalOrder($orders_status)
    {

        if (!request()->has('from') || !request()->has('to')) {

            request()->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            request()->merge(['to' => Carbon::now()->toDateString()]);
        }

        $balance = 0;

        $orders = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)->where('status', $orders_status)->get();

        foreach ($orders as $order) {
            $balance += $order->total_price;
        }

        return $balance;
    }
}


// get orders count
if (!function_exists('ordersCount')) {
    function ordersCount($orders_status)
    {
        $orders = Order::where('status', $orders_status)->get();
        return $orders->count();
    }
}



// get product rating
if (!function_exists('getRatingWithStars')) {
    function getRatingWithStars($rating)
    {
        $check = str_contains($rating, '.');
        $rating = floor($rating);
        $stars = '';

        for ($i = 0; $i < $rating; $i++) {
            $stars .= '<span class="fa fa-star text-warning fs--1"></span>';
        }

        if ($check) {
            $rating++;
            $stars .= '<span class="fa fa-star-half-alt text-warning star-icon fs--1"></span>';
        }

        for ($i = 0; $i < 5 - $rating; $i++) {
            $stars .= '<span class="fa fa-star text-300 fs--1"></span>';
        }

        return $stars;
    }
}


// get product average rating
if (!function_exists('getAverageRatingWithStars')) {
    function getAverageRatingWithStars($product)
    {

        $count = 0;
        $rating = 0;

        foreach ($product->reviews as $review) {
            $count++;
            $rating += $review->rating;
        }

        if ($count != 0) {
            $rating = $rating / $count;
        }

        $check = str_contains($rating, '.');
        $rating = floor($rating);
        $stars = '';

        for ($i = 0; $i < $rating; $i++) {
            $stars .= '<span class="fa fa-star text-warning"></span>';
        }

        if ($check) {
            $rating++;
            $stars .= '<span class="fa fa-star-half-alt text-warning star-icon"></span>';
        }

        for ($i = 0; $i < 5 - $rating; $i++) {
            $stars .= '<span class="fa fa-star text-300"></span>';
        }

        return $stars;
    }
}


// get product rating
if (!function_exists('getRatingCount')) {
    function getRatingCount($product)
    {
        $count = 0;
        foreach ($product->reviews as $review) {
            $count++;
        }
        return $count;
    }
}


// create order history
if (!function_exists('createOrderHistory')) {
    function createOrderHistory($order, $status)
    {

        if (Auth::user()->hasRole('affiliate') && $status == 'canceled') {
            $status = 'You canceled the order';
        }

        OrderHistory::create([
            'order_id' => $order->id,
            'status' => $status,
        ]);
    }
}


// get order history
if (!function_exists('getOrderHistory')) {
    function getOrderHistory($status)
    {

        $order_status = '';

        switch ($status) {
            case 'pending':
                $order_status = '<span class="badge badge-soft-warning ">' . __($status) . '</span>';
                break;
            case 'confirmed':
                $order_status = '<span class="badge badge-soft-primary ">' . __($status) . '</span>';
                break;
            case 'on the way':
                $order_status = '<span class="badge badge-soft-info ">' . __($status) . '</span>';
                break;
            case 'delivered':
                $order_status = '<span class="badge badge-soft-success ">' . __($status) . '</span>';
                break;
            case 'canceled':
                $order_status = '<span class="badge badge-soft-danger ">' . __($status) . '</span>';
                break;
            case 'in the mandatory period':
                $order_status = '<span class="badge badge-soft-warning ">' . __($status) . '</span>';
                break;
            case 'returned':
                $order_status = '<span class="badge badge-soft-danger ">' . __($status) . '</span>';
                break;
            case 'RTO':
                $order_status = '<span class="badge badge-soft-danger ">' . __($status) . '</span>';
                break;
            case 'You canceled the order':
                $order_status = '<span class="badge badge-soft-danger ">' . __($status) . '</span>';
                break;
            default:
                $order_status = '';
                break;
        }

        return $order_status;
    }
}
