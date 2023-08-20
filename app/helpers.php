<?php

use App\Events\NewNotification;
use App\Mail\NewOrder;
use App\Models\Account;
use App\Models\Address;
use App\Models\Attendance;
use App\Models\Balance;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Cost;
use App\Models\Country;
use App\Models\EmployeeInfo;
use App\Models\EmployeePermission;
use App\Models\Entry;
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
use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Reward;
use App\Models\Role;
use App\Models\RunningOrder;
use App\Models\SalaryCard;
use App\Models\SettlementSheet;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\UserInfo;
use App\Models\View;
use App\Models\Warehouse;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use PhpParser\Node\Stmt\TryCatch;

use SnapBusinessSDK\Api\ConversionApi;
use SnapBusinessSDK\Model\CapiEvent;
use SnapBusinessSDK\Util\CapiConstants;


use FacebookAds\Api;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\EventRequestAsync;
use FacebookAds\Object\ServerSide\UserData;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;

use Stevebauman\Location\Facades\Location;


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
        $media = Media::find($media_id);

        if ($media != null) {
            if ($media->productImages->count() == 0 && $media->brands->count() == 0 && $media->categories->count() == 0 && $media->countries->count() == 0 && $media->productCombinations->count() == 0 && $media->slides->count() == 0 && $media->websiteOptions->count() == 0 && $media->websiteSettings->count() == 0  && $media->installment_companies->count() == 0) {
                try {
                    Storage::disk('public')->delete(substr($media->path, '7'));
                    $media->forceDelete();
                    return true;
                } catch (\Throwable $th) {
                    return null;
                }
            } else {
                return null;
            }
        }
    }
}

if (!function_exists('getImage')) {
    function getImage($item)
    {
        if ($item != null) {
            if (isset($item->media)) {
                if ($item->media != null) {
                    return $item->media->path;
                }
            }
        }

        return null;
    }
}

if (!function_exists('getImageAsset')) {
    function getImageAsset($item)
    {
        if ($item != null) {
            if (isset($item->media)) {
                if ($item->media != null) {
                    return asset($item->media->path);
                }
            }
        }

        return null;
    }
}

if (!function_exists('getProductPrice')) {
    function getProductPrice($product, $combination = null)
    {


        if ($product->product_type == 'variable' && $combination == null) {

            $combinations = $product->combinations;
            $min_price = 0;
            foreach ($combinations as $index => $combination) {
                $price = productPrice($product, $combination->id, 'vat');
                if ($index == 0) {
                    $min_price = $price;
                    $combination_s = $combination;
                } else {
                    if ($price < $min_price) {
                        $min_price = $price;
                        $combination_s = $combination;
                    }
                }
            }

            return $h4 = getProductPriceForView($combination_s->sale_price, $combination_s->discount_price);
        } elseif ($product->product_type == 'variable' && $combination != null) {
            return $h4 = getProductPriceForView($combination->sale_price, $combination->discount_price);
        } else {
            return $h4 = getProductPriceForView($product->sale_price, $product->discount_price);
        }
    }
}


if (!function_exists('getProductPriceForView')) {
    function getProductPriceForView($price, $discount)
    {
        $h4 = '';
        if ($discount == 0) {
            return    '<h4>' . calcWebsiteTax($price)  . getCurrency() . '</h4>';
        } else {
            return '<h4>' . calcWebsiteTax($discount)  . getCurrency() . ' ' . '<del>' . calcWebsiteTax($price)  . getCurrency() . '</del>
            </h4>' . getProductDiscountForView($price, $discount);
        }
        return $h4;
    }
}

if (!function_exists('getProductPriceForInstallment')) {
    function getProductPriceForInstallment($price, $discount)
    {
        $h4 = '';
        if ($discount == 0) {
            return    calcWebsiteTax($price);
        } else {
            return calcWebsiteTax($discount);
        }
        return $h4;
    }
}

if (!function_exists('getProductDiscountForView')) {
    function getProductDiscountForView($price, $discount)
    {
        $span = '';
        if ($discount != 0) {
            $discount = (($price - $discount) / $price) * 100;
            $span = ' ' .  '<span>' . '( ' .  __('discount') . ' '  . round($discount) . ' %' . ' )' . '</span>';
        }
        return $span;
    }
}

if (!function_exists('calcWebsiteTax')) {
    function calcWebsiteTax($price)
    {
        if (setting('website_vat')) {

            $price = $price + calcTax($price, 'vat');
        }

        return $price;
    }
}



if (!function_exists('productPrice')) {
    function productPrice($product, $combination = null, $vat = null)
    {


        if ($vat && $product->vendor_id == null) {
            if ($product->product_type == 'variable') {

                if ($combination == null) {
                    $combinations = $product->combinations;
                    $min_price = 0;
                    foreach ($combinations as $index => $combination) {
                        $price = productPrice($product, $combination->id, 'vat');
                        if ($index == 0) {
                            $min_price = $price;
                            $combination_s = $combination;
                        } else {
                            if ($price < $min_price) {
                                $min_price = $price;
                                $combination_s = $combination;
                            }
                        }
                    }

                    return getProductPriceForInstallment($combination_s->sale_price, $combination_s->discount_price);
                } else {
                    $com = ProductCombination::findOrFail($combination);
                    return  $com->discount_price == 0 ? calcWebsiteTax($com->sale_price)  : calcWebsiteTax($com->discount_price);
                }
            } else {

                return $product->discount_price == 0 ? calcWebsiteTax($product->sale_price)  : calcWebsiteTax($product->discount_price);
            }
        } else {
            if ($product->product_type == 'variable') {
                $com = ProductCombination::findOrFail($combination);
                return $com->discount_price == 0 ? $com->sale_price : $com->discount_price;
            } else {
                return $product->discount_price == 0 ? $product->sale_price : $product->discount_price;
            }
        }
    }
}


if (!function_exists('getProductAccount')) {
    function getProductAccount($product, $combination_id = null)
    {
        if ($product->product_type == 'variable') {
            $account = Account::where('reference_id', $combination_id)->where('type', 'variable_product')->first();
        } else {
            $account = Account::where('reference_id', $combination_id)->where('type', 'simple_product')->first();
        }
        return $account;
    }
}


if (!function_exists('getProductCostAccount')) {
    function getProductCostAccount($product, $combination_id = null)
    {
        if ($product->product_type == 'variable') {
            $account = Account::where('reference_id', $combination_id)->where('type', 'variable_product_cost')->first();
        } else {
            $account = Account::where('reference_id', $combination_id)->where('type', 'simple_product_cost')->first();
        }
        return $account;
    }
}





if (!function_exists('getCartSubtotal')) {
    function getCartSubtotal($cart_items)
    {
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $subtotal +=  $item->qty *  productPrice($item->product, $item->product_combination_id, 'vat');
        }

        return $subtotal;
    }
}


if (!function_exists('createSlug')) {
    function createSlug($slug)
    {
        $slug = strtolower($slug);

        // $slug = str_replace("-", " ", $slug);
        // $slug = str_replace("-", "/", $slug);

        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = str_replace("/", "-", $slug);

        // remove duplicate divider
        $slug = preg_replace('~-+~', '-', $slug);


        // $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug)));

        return $slug;
    }
}


if (!function_exists('createSlug')) {
    function storeFile($file, $location)
    {
        $path = '';
        $path = $file->store('files/' + $location);
        return $path;
    }
}


if (!function_exists('getProductImage')) {
    function getProductImage($product)
    {
        if ($product->media_id != null && $product->media != null) {
            return asset($product->media->path);
        } elseif ($product->images->count() > 0) {
            return asset($product->images[0]->media->path);
        } else {
            return asset('storage/images/products/place-holder.jpg');
        }
    }
}

if (!function_exists('getProductImage2')) {
    function getProductImage2($product)
    {
        if ($product->media_id != null && $product->media != null) {
            if ($product->images->count() > 0) {
                return asset($product->images[0]->media->path);
            } else {
                return asset($product->media->path);
            }
        } else {
            if ($product->images->count() > 0) {
                return asset($product->images[0]->media->path);
            } else {
                return asset('public/images/products/place-holder.jpg');
            }
        }
    }
}


if (!function_exists('getUserInfo')) {
    function getUserInfo($user)
    {
        $info = UserInfo::where('user_id', $user->id)->first();
        return $info;
    }
}

if (!function_exists('getEmployeeInfo')) {
    function getEmployeeInfo($user)
    {
        $info = EmployeeInfo::where('user_id', $user->id)->first();
        return $info;
    }
}


if (!function_exists('getbranches')) {
    function getbranches()
    {
        $user = Auth::user();

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }
        return $branches;
    }
}











if (!function_exists('checkUserInfo')) {
    function checkUserInfo($user)
    {
        $info = UserInfo::where('user_id', $user->id)->first();
        if ($info == null) {
            return false;
        }

        if ($info != null && $info->store_status == 1) {
            return false;
        } else {
            return true;
        }
    }
}


if (!function_exists('getMediaPath')) {
    function getMediaPath($media_id)
    {
        $media = Media::find($media_id);
        return $media ? asset($media->path) : null;
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
        $country = Country::find(setting('country_id'));
        if ($country == null) {
            $country = Country::first();
        }
        return $country;
    }
}


if (!function_exists('getCountry')) {
    function getCountry()
    {

        if (Auth::check()) {
            $country = Country::find(Auth::user()->country_id);
        } else {
            $country = Country::find(setting('country_id'));
        }

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


if (!function_exists('getBrands')) {
    function getBrands()
    {
        $country = getCountry();
        $brands = Brand::where('country_id', $country->id)->where('status', 'active')->get();
        return $brands;
    }
}


if (!function_exists('getCategories')) {
    function getCategories()
    {
        $country = getCountry();
        $categories = Category::whereNull('parent_id')->where('country_id', $country->id)->where('status', 'active')->orderBy('sort_order', 'asc')->get();
        return $categories;
    }
}

if (!function_exists('getName')) {
    function getName($item)
    {
        if (isset($item) && isset($item->name_ar) && isset($item->name_en)) {
            if (app()->getLocale() == 'ar') {
                return $item->name_ar;
            } else {
                return $item->name_en;
            }
        }
    }
}


if (!function_exists('getAddress')) {
    function getAddress()
    {
        if (Auth::check()) {
            $address = Address::where('user_id', Auth::id())->first();
        } else {
            $address = Address::where('session_id', request()->session()->token())->first();
        }

        return $address;
    }
}


if (!function_exists('getAccu')) {
    function getAccu($account)
    {
        $account = Account::where('reference_id', $account->parent_id)->where('type', 'accumulated_depreciation')->first();
        return $account;
    }
}


if (!function_exists('getDep')) {
    function getDep($account)
    {
        $account = Account::where('reference_id', $account->parent_id)->where('type', 'depreciation_expenses')->first();
        return $account;
    }
}


if (!function_exists('getSubAccounts')) {
    function getSubAccounts($account_id)
    {
        $accounts = Account::where('parent_id', $account_id);
        return $accounts;
    }
}


if (!function_exists('getAccount')) {
    function getAccount($account_id)
    {
        $account = Account::findOrFail($account_id);
        return $account;
    }
}

if (!function_exists('getAccountBalance')) {
    function getAccountBalance($account_id, $type, $from = null, $to = null)
    {
        $account = Account::findOrFail($account_id);
        $cr_amount = 0;
        $dr_amount = 0;

        $arrays = flatten($account->childrenRecursive()->get()->toArray());
        $accounts = [];
        foreach ($arrays as $array) {
            array_push($accounts, $array['id']);
        }
        array_push($accounts, $account_id);

        if (!$from || !$to) {
            $from = Carbon::now()->subDay(365)->toDateString();
            $to = Carbon::now()->toDateString();
        }


        foreach (Entry::whereIn('account_id', $accounts)->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)->get() as $entry) {
            $cr_amount += $entry->cr_amount;
            $dr_amount += $entry->dr_amount;
        }

        if ($type == 'cr') {
            return round($cr_amount, 2);
        } elseif ($type == 'dr') {
            return round($dr_amount, 2);
        }
    }
}


if (!function_exists('getTrialBalance')) {
    function getTrialBalance($account_id, $from = null, $to = null)
    {
        $account = Account::findOrFail($account_id);
        $cr_amount = 0;
        $dr_amount = 0;

        $arrays = flatten($account->childrenRecursive()->get()->toArray());
        $accounts = [];
        foreach ($arrays as $array) {
            array_push($accounts, $array['id']);
        }
        array_push($accounts, $account_id);


        $balance = 0;



        if (!$from || !$to) {
            $from = Carbon::now()->subDay(1000000)->toDateString();
            $to = Carbon::now()->toDateString();
        }

        if ($account->type == 'accumulated_depreciation') {
            foreach (Entry::whereIn('account_id', $accounts)
                ->whereDate('created_at', '<=', Carbon::now()->toDateString())->get() as $entry) {
                $cr_amount += $entry->cr_amount;
                $dr_amount += $entry->dr_amount;
            }
        } else {
            foreach (Entry::whereIn('account_id', $accounts)->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)->get() as $entry) {
                $cr_amount += $entry->cr_amount;
                $dr_amount += $entry->dr_amount;
            }
        }






        $type = getAccountType($account);

        if ($type == 'debit') {
            $balance = round($dr_amount - $cr_amount, 2);
        } else {
            $balance = round($cr_amount - $dr_amount, 2);
        }

        return $balance;
    }
}


if (!function_exists('getAccountType')) {
    function getAccountType($account)
    {
        $type = '';
        if ($account->account_type == 'assets' || $account->account_type == 'expenses') {
            $type = 'debit';
        } else {
            $type = 'credit';
        }
        return $type;
    }
}

if (!function_exists('getSettleAmount')) {
    function getSettleAmount()
    {

        $assets_account = Account::findOrFail(setting('assets_account'));

        $assets = 0;
        $assets_cr = getTrialBalance($assets_account->id, null, null)['cr'];
        $assets_dr = getTrialBalance($assets_account->id, null, null)['dr'];

        if ($assets_cr > $assets_dr) {
            $assets = $assets_cr;
        } else {
            $assets = $assets_dr;
        }

        $vat_account = Account::findOrFail(setting('vat_purchase_account'));

        $vat = 0;
        $vat_cr = getTrialBalance($vat_account->id, null, null)['cr'];
        $vat_dr = getTrialBalance($vat_account->id, null, null)['dr'];

        if ($vat_cr > $vat_dr) {
            $vat = $vat_cr;
        } else {
            $vat = $vat_dr;
        }


        $suppliers_account = Account::findOrFail(setting('suppliers_account'));

        $suppliers = 0;
        $suppliers_cr = getTrialBalance($suppliers_account->id, null, null)['cr'];
        $suppliers_dr = getTrialBalance($suppliers_account->id, null, null)['dr'];

        if ($suppliers_cr > $suppliers_dr) {
            $suppliers = $suppliers_cr;
        } else {
            $suppliers = $suppliers_dr;
        }


        $wct_account = Account::findOrFail(setting('wct_account'));

        $wct = 0;
        $wct_cr = getTrialBalance($wct_account->id, null, null)['cr'];
        $wct_dr = getTrialBalance($wct_account->id, null, null)['dr'];

        if ($wct_cr > $wct_dr) {
            $wct = $wct_cr;
        } else {
            $wct = $wct_dr;
        }

        $cs_account = Account::findOrFail(setting('cs_account'));
        $cs = 0;
        $cs_cr = getTrialBalance($cs_account->id, null, null)['cr'];
        $cs_dr = getTrialBalance($cs_account->id, null, null)['dr'];

        if ($cs_cr > $cs_dr) {
            $cs = $cs_cr;
        } else {
            $cs = $cs_dr;
        }


        $sttle = 0;
        $sttle_cr = 0;
        $sttle_dr = 0;

        foreach (Entry::where('type', 'stockSettle')->get() as $entry) {
            $sttle_cr += $entry->cr_amount;
            $sttle_dr += $entry->dr_amount;
        }

        if ($sttle_cr > $sttle_dr) {
            $sttle = $sttle_cr;
        } else {
            $sttle = $wct_dr;
        }

        // dd($assets, $vat, $cs, $suppliers, $wct, $sttle);

        $amount = ($assets + $vat + $cs) - ($suppliers + $wct + $sttle);

        return $amount;
    }
}




if (!function_exists('getCartItems')) {
    function getCartItems($user = null)
    {

        if ($user) {
            return CartItem::where('user_id', $user->id)->get();
        }

        if (Auth::check()) {
            $cart_items = CartItem::where('user_id', Auth::id())->get();
        } else {
            // temporary solution for session problem on 404 page
            try {
                $cart_items = CartItem::where('session_id', request()->session()->token())->get();
            } catch (Exception $ex) {
                $cart_items = CartItem::where(null);
            }
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
    function getProductName($product, $combination = null, $locale = null)
    {

        $text = '';

        if ($locale == null) {
            $locale = app()->getLocale();
        }

        $text = $locale == 'ar' ? $product->name_ar : $product->name_en;

        if ($combination) {

            foreach ($combination->variations as $index => $variation) {
                if ($index == 0) {
                    $text .= ' (';
                }
                $text .= $locale == 'ar' ? $variation->variation->name_ar : $variation->variation->name_en;
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
            $combination = ProductCombination::find($combination_id);
            return $combination;
        }
    }
}

if (!function_exists('getCombinationData')) {
    function getCombinationData($combination_id = null, $data = null)
    {
        $combination = getCombination($combination_id);

        if ($combination_id == null || $combination == null) {
            return null;
        } else {
            $data = $combination->$data;
            return $data;
        }
    }
}






// set localizaition in session
if (!function_exists('setLocaleBySession')) {
    function setLocaleBySession()
    {
        if (DB::connection()->getDatabaseName() != '' && Auth::check()) {
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

            $app_name = env('APP_NAME');

            $client->messages->create(
                $user->phone, // to
                ["body" => "Your {$app_name} Verification Code Is : {$code}", "from" => "{$app_name}"]
            );

            $from_email = 'Info@sonoo.online';
            $to      = $user->email;
            $subject = "{$app_name} - Verification";
            $txt     = "Your {$app_name} verification code is : " . $code;
            $headers = "From: {$from_email}" . "\r\n" .
                "CC: {$from_email}";

            mail($to, $subject, $txt, $headers);
        } catch (TwilioException $e) {
            echo $e->getCode() . ' : ' . $e->getMessage() . "<br>";
        }
    }
}


// send sms for verification
if (!function_exists('sendEmail')) {
    function sendEmail($type, $data, $email_type)
    {
        try {
            if ($type == 'order') {

                // $data = array('name' => "Joi die");
                // Mail::send('dashboard.orders.template', $data, function ($message) {
                //     $message->to('islam.shaaban13@gmail.com', 'Devnote Tutorial')->subject('Laravel HTML Mail Testing');
                //     $message->from('devnote@gmail.com', 'Joi die');
                // });

                Mail::send(new NewOrder($data, $email_type));
            }
        } catch (Exception $e) {
            alertError('There was an error sending email', 'حدث خطأ في ارسال الايميل');
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
        $old = Carbon::parse($old);
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

// check client for trash
if (!function_exists('checkClientForTrash')) {
    function checkClientForTrash($client)
    {
        if ($client->user->count() > 0 || $client->user->notes->count() > 0 || $client->user->messages->count() > 0) {
            return false;
        } else {
            return true;
        }
    }
}

// check user for trash
if (!function_exists('checkBranchForTrash')) {
    function checkBranchForTrash($branch)
    {
        if ($branch->users->count() > 0 || $branch->warehouses->count() > 0) {
            return false;
        } else {
            return true;
        }
    }
}




// check user for trash
if (!function_exists('checkTaxForTrash')) {
    function checkTaxForTrash($tax)
    {
        if (setting('vat') != null && setting('vat') == $tax->id) {
            return false;
        } else {
            return true;
        }
    }
}

// check account for trash
if (!function_exists('checkAccountForTrash')) {
    function checkAccountForTrash($account)
    {
        if ($account->accounts->count() > 0  || $account->entries->count() > 0) {
            return false;
        } else {
            return true;
        }
    }
}

// flatten array
if (!function_exists('flatten')) {
    function flatten($array)
    {
        $flatArray = [];

        if (!is_array($array)) {
            $array = (array)$array;
        }

        foreach ($array as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $flatArray = array_merge($flatArray, flatten($value));
            } else {
                $flatArray[0][$key] = $value;
            }
        }

        return $flatArray;
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



if (!function_exists('checkShippingCompanyForTrash')) {
    function checkShippingCompanyForTrash($shipping_company)
    {
        if ($shipping_company->states()->count() > '0') {
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



// get product quantity for simple , variable and vendor product
if (!function_exists('productQuantity')) {
    function productQuantity($product_id, $combination_id = null, $warehouse_id = null, $warehouses = null)
    {

        $quantity_in = 0;
        $quantity_out = 0;
        $quantity = 0;

        $product = Product::findOrFail($product_id);

        // if product belong to vendor then get vendor warehouse and calculate quantity
        if ($product->vendor_id != null) {
            $warehouse = Warehouse::where('vendor_id', $product->vendor_id)->first();
            $warehouse_id = $warehouse->id;
        }

        if ($warehouses) {
            $warehouses = $warehouses->pluck('id')->toArray();
        } else {
            $warehouses = Warehouse::all()->pluck('id')->toArray();
        }

        foreach ($product->stocks->where('product_combination_id', $combination_id ? '==' : '!=', $combination_id)->where('warehouse_id', $warehouse_id ? '==' : '!=', $warehouse_id)->whereIn('warehouse_id', $warehouses) as $stock) {
            if ($stock->stock_status == 'IN') {
                $quantity_in += $stock->qty;
            } else {
                $quantity_out += $stock->qty;
            }
        }

        $quantity = $quantity_in - $quantity_out;
        return $quantity;
    }
}


// get product quantity for simple , variable and vendor product for website
if (!function_exists('productQuantityWebsite')) {
    function productQuantityWebsite($product_id, $combination_id = null, $warehouse_id = null, $warehouses = [])
    {

        $quantity_in = 0;
        $quantity_out = 0;
        $quantity = 0;

        $product = Product::findOrFail($product_id);

        // if product belong to vendor then get vendor warehouse and calculate quantity
        if ($product->vendor_id != null) {
            $warehouse = Warehouse::where('vendor_id', $product->vendor_id)->first();
            $warehouse_id = $warehouse->id;
        }

        foreach ($product->stocks->where('product_combination_id', $combination_id ? '==' : '!=', $combination_id)->where('warehouse_id', $warehouse_id ? '==' : '!=', $warehouse_id)->whereIn('warehouse_id', $warehouses) as $stock) {
            if ($stock->stock_status == 'IN') {
                $quantity_in += $stock->qty;
            } else {
                $quantity_out += $stock->qty;
            }
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
            $sender_name = $sender->name;
        } else {
            $media = asset(websiteSettingMedia('header_icon'));
            $sender_id = $sender;
            $sender_name = 'guest';
        }

        $notification = Notification::create([
            'user_id' => $user->id,
            'sender_id' => $sender_id,
            'sender_name'  => $sender_name,
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
            'sender_name'  => $sender_name,
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

if (!function_exists('getTaxRate')) {
    function getTaxRate($type)
    {

        switch ($type) {
            case 'wht_invoice_amount':
                $tax_rate = 300;
                break;
            case 'vendors_tax':
                $tax_rate = 5;
                break;
            case 'income_tax':
                $tax_rate = 22.5;
                break;
            case 'wht_services':
                $tax_rate = 3;
                break;
            case 'wht_products':
                $tax_rate = 1;
                break;
            case 'vat':
                $tax_rate = 14;
                break;
            default:
                $tax_rate = 0;
                break;
        }

        return $tax_rate;
    }
}


if (!function_exists('getTaxType')) {
    function getTaxType($type)
    {

        switch ($type) {
            case 'vendors_tax':
                $type = 'plus';
                break;
            case 'income_tax':
                $type = 'plus';
                break;
            case 'wht_services':
                $type = 'minus';
                break;
            case 'wht_products':
                $type = 'minus';
                break;
            case 'vat':
                $type = 'plus';
                break;
            default:
                $type = 'plus';
                break;
        }

        return $type;
    }
}



if (!function_exists('getTaxName')) {
    function getTaxName($type)
    {

        $name = [];

        switch ($type) {
            case 'vendors_tax':
                $name['ar'] = 'ضريبة عمولة لبيع منتجات الموردين';
                $name['en'] = 'vendors_tax';
                break;
            case 'income_tax':
                $name['ar'] = 'ضريبة الدخل';
                $name['en'] = 'income_tax';
                break;
            case 'wht_services':
                $name['ar'] = 'ضريبة الخصم والتحصيل للخدمات';
                $name['en'] = 'wht_services';
                break;
            case 'wht_products':
                $name['ar'] = 'ضريبة الخصم والتحصيل للتوريدات';
                $name['en'] = 'wht_products';
                break;
            case 'vat':
                $name['ar'] = 'ضريبة القيمة المضافة';
                $name['en'] = 'vat';
                break;
            default:
                $name['ar'] = '';
                $name['en'] = '';
                break;
        }

        return $name;
    }
}




if (!function_exists('setting')) {
    function setting($type)
    {
        $setting = Setting::where('type', $type)->first();

        $taxes = array(
            'wht_invoice_amount',
            'vendors_tax',
            'income_tax',
            'wht_services',
            'wht_products',
            'vat'
        );

        if ($setting == null && in_array($type, $taxes)) {

            if ($type != 'wht_invoice_amount') {

                $tax_name = getTaxName($type);
                $tax_type = getTaxType($type);

                $tax = tax::create([
                    'name_ar' => $tax_name['ar'],
                    'name_en' => $tax_name['en'],
                    'type' => $tax_type,
                    'description' => $type,
                    'tax_rate' => getTaxRate($type),
                    'created_by' => Auth::id(),
                ]);

                $setting = Setting::create([
                    'type' => $type,
                    'value' => $tax->id,
                ]);
            } else {
                $setting = Setting::create([
                    'type' => $type,
                    'value' => getTaxRate($type),
                ]);
            }
        }


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
        $category = Category::find($item->value_ar);
        return $category ? $category : null;
    }
}

if (!function_exists('websiteSettingMedia')) {
    function websiteSettingMedia($type)
    {
        $setting = WebsiteSetting::where('type', $type)->first();

        if (isset($setting)) {
            if (isset($setting->media)) {
                if ($setting->media != null) {
                    return $setting->media ? $setting->media->path : null;
                }
            }
        }

        return 'storage/images/users/placeholder-icon.png';
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








if (!function_exists('settingAccounts')) {
    function settingAccounts($type)
    {
        $setting = Setting::where('type', $type)->get();
        return $setting;
    }
}

if (!function_exists('getBranchName')) {
    function getBranchName($branch_id)
    {
        $item = Branch::findOrFail($branch_id);

        if (isset($item) && isset($item->name_ar) && isset($item->name_en)) {
            if (app()->getLocale() == 'ar') {
                return $item->name_ar;
            } else {
                return $item->name_en;
            }
        }
    }
}


if (!function_exists('getUserBranchId')) {
    function getUserBranchId($user)
    {

        if ($user->branch_id != null) {
            $branch_id = $user->branch->id;
        } else {
            $branch_id = null;
        }

        return $branch_id;
    }
}

if (!function_exists('getUserBranches')) {
    function getUserBranches($user)
    {

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        return $branches;
    }
}

if (!function_exists('attachRole')) {
    function attachRole($user, $role_name)
    {

        $role = Role::where('name', $role_name)->first();

        if (!$role) {
            $role = Role::create([
                'name' => $role_name,
                'display_name' => $role_name,
                'description' => $role_name,
            ]);
        }

        $user->attachRole($role);
    }
}


if (!function_exists('userCreationData')) {
    function userCreationData($user, $role_name = null, $bonus = 0)
    {

        Cart::create([
            'user_id' => $user->id,
        ]);

        Balance::create([
            'user_id' => $user->id,
            'available_balance' => 0,
            'outstanding_balance' => 0,
            'pending_withdrawal_requests' => 0,
            'completed_withdrawal_requests' => 0,
            'bonus' => $user->hasRole($role_name) ?  $bonus : 0,
        ]);
    }
}


if (!function_exists('getDivForAccountsSetting')) {
    function getDivForAccountsSetting($type, $label, $accounts, $branch_id, $more_accounts = null, $reference_account = null)
    {

        $output = '';
        $name = [];

        if ($reference_account) {
            $text = ' - ' . getName($reference_account);
        } else {
            $text = '';
        }

        $output .= '<div class="mb-3">
                        <label class="form-label" for="' . $type . '">';
        $output .= __($label) . $text . '</label><select class="form-select js-choice" ';

        $output .= 'aria-label="" name="' . $type . '[' . $branch_id . ']'   . '" id="' . $type . '"><option value="">';

        $output .= __('select account') . '</option>';


        foreach ($accounts->where('branch_id', $branch_id) as $account) {
            $output .= '<option value="' .  $account->id . '"';
            $output .= settingAccount($type, $branch_id) == $account->id ? 'selected' : '';
            $output .= '>';
            $output .= getName($account) . ' - ' . getBranchName($branch_id) . '</option>';
        }

        if ($more_accounts) {
            foreach ($more_accounts->where('branch_id', $branch_id) as $account) {
                $output .= '<option value="' .  $account->id . '"';
                $output .= settingAccount($type, $branch_id) == $account->id ? 'selected' : '';
                $output .= '>';
                $output .= getName($account) . ' - ' . getBranchName($branch_id) . '</option>';
            }
        }



        $output .= '</select>';

        $output .= '</div> ';



        return $output;
    }
}



// update accounts setting
if (!function_exists('updateAccountSetting')) {
    function updateAccountSetting($type, $request)
    {


        if ($request[$type] != null && is_array($request[$type])) {

            foreach ($request[$type] as $index => $value) {

                $setting = Setting::where('type', $type)->where('reference_type', 'accounts')->where('reference_id', $index)->first();

                if ($value != null && $setting == null) {
                    $branch = Branch::findOrFail($index);
                    $account = Account::findOrFail($value);

                    Setting::create([
                        'type' => $type,
                        'value' => $account->id,
                        'reference_type' => 'accounts',
                        'reference_id' => $branch->id
                    ]);
                } elseif ($value != null && $setting != null && $setting->value != $value) {

                    $account = Account::findOrFail($setting->value);
                    $new_account = Account::findOrFail($value);

                    $childrens = $account->accounts->where('type', $type);
                    $entries = $account->entries;

                    $last_account = $new_account->accounts->last();

                    if ($last_account == null) {
                        $last_code = $new_account->code . '00';
                    } else {
                        $last_code = $last_account->code;
                    }

                    foreach ($childrens as $children) {
                        $last_code += 1;
                        $children->update([
                            'parent_id' => $new_account->id,
                            'code' => $last_code,
                        ]);
                    }

                    foreach ($entries as $entry) {
                        $entry->update([
                            'account_id' => $new_account->id
                        ]);
                    }

                    $setting->update([
                        'value' => $new_account->id,
                    ]);
                }
            }
        }
    }
}


// update setting values
if (!function_exists('updateSetting')) {
    function updateSetting($type, $request)
    {

        $setting = Setting::where('type', $type)->first();

        if ($setting == null) {

            Setting::create([
                'type' => $type,
                'value' => is_array($request[$type]) ? serialize($request[$type]) : $request[$type],
            ]);
        } elseif ($setting->value != $request[$type]) {

            $setting->update([
                'value' => is_array($request[$type]) ? serialize($request[$type]) : $request[$type],
            ]);

            if ($type == 'country_id') {

                $countries = Country::all();
                foreach ($countries as $country) {
                    $country->update([
                        'is_default' => $country->id == $request[$type] ? '1' : '0'
                    ]);
                }
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
    function changePendingWithdrawalBalance($user, $amount, $order_id = 0, $status = null, $type)
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


if (!function_exists('orderStatus')) {
    function orderStatus($status)
    {
        switch ($status) {
            case "pending":
                $status_ar = '<span class="badge rounded-pill bg-danger custom-badge">' . __("Pending") . '</span>';
                break;
            case "confirmed":
                $status_ar = '<span class="badge rounded-pill bg-danger custom-badge">' . __("Confirmed") . '</span>';
                break;
            case "on the way":
                $status_ar = '<span class="badge rounded-pill bg-info custom-badge">' . __("Shipped") . '</span>';
                break;
            case "delivered":
                $status_ar = '<span class="badge rounded-pill bg-info custom-badge">' . __("Delivered") . '</span>';
                break;
            case "canceled":
                $status_ar = '<span class="badge rounded-pill bg-secondary custom-badge">' . __("Canceled") . '</span>';
                break;
            case "in the mandatory period":
                $status_ar = '<span class="badge rounded-pill bg-info custom-badge">' . __("Delivered") . '</span>';
                break;
            case "Waiting for the order amount to be released":
                $status_ar = '<span class="badge rounded-pill bg-info custom-badge">' . __("Delivered") . '</span>';
                break;
            case "returned":
                $status_ar = '<span class="badge rounded-pill bg-secondary custom-badge">' . __("Returned") . '</span>';
                break;
            case "RTO":
                $status_ar = '<span class="badge rounded-pill bg-secondary custom-badge">' . __("RTO") . '</span>';
                break;
            default:
                break;
        }
        return $status_ar;
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
            case "completed":
                $status_ar = "مكتمل";
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

        if ($new_status == 'delivered') {
            if (setting('vat_sales_account') == null) {
                return false;
            }
        }

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

// check order status for change
if (!function_exists('checkPurchaseOrderStatus')) {
    function checkPurchaseOrderStatus($new_status, $old_status)
    {
        // completed
        // returned
        if (($new_status == $old_status)) {
            // can not change to same status
            return false;
        } elseif ($old_status != 'completed' && $new_status == 'returned') {
            // can not change status to returned except delivered
            return false;
        } elseif ($old_status == 'returned') {
            return false;
        } elseif ($old_status == 'completed' && $new_status != 'returned') {
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
            $stars .= '<i class="fa fa-star text-warning fs--1"></i>';
        }

        if ($check) {
            $rating++;
            $stars .= '<i class="fa fa-star-half-o text-warning star-icon fs--1"></i>';
        }

        for ($i = 0; $i < 5 - $rating; $i++) {
            $stars .= '<i class="fa fa-star text-300 fs--1"></i>';
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
            $stars .= '<i class="fa fa-star text-warning fs--1"></i>';
        }

        if ($check) {
            $rating++;
            $stars .= '<i class="fa fa-star-half-o text-warning star-icon fs--1"></i>';
        }

        for ($i = 0; $i < 5 - $rating; $i++) {
            $stars .= '<i class="fa fa-star text-300 fs--1"></i>';
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
            case 'completed':
                $order_status = '<span class="badge badge-soft-success ">' . __($status) . '</span>';
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


// get running status
if (!function_exists('getRunningStatus')) {
    function getRunningStatus($status)
    {

        $order_status = '';

        switch ($status) {
            case 'pending':
                $order_status = '<span class="badge badge-soft-warning ">' . __($status) . '</span>';
                break;
            case 'completed':
                $order_status = '<span class="badge badge-soft-success ">' . __($status) . '</span>';
                break;
            case 'partial':
                $order_status = '<span class="badge badge-soft-danger ">' . __('partial qty') . '</span>';
                break;
            default:
                $order_status = '';
                break;
        }

        return $order_status;
    }
}

// get order history
if (!function_exists('getPaymentStatus')) {
    function getPaymentStatus($status)
    {

        $order_status = '';

        switch ($status) {
            case 'pending':
                $order_status = '<span class="badge badge-soft-warning ">' . __($status) . '</span>';
                break;
            case 'paid':
                $order_status = '<span class="badge badge-soft-success ">' . __($status) . '</span>';
                break;
            case 'partial':
                $order_status = '<span class="badge badge-soft-info ">' . __($status) . '</span>';
                break;
            case 'faild':
                $order_status = '<span class="badge badge-soft-danger ">' . __($status) . '</span>';
                break;

            default:
                $order_status = '';
                break;
        }

        return $order_status;
    }
}

// get stage fields
if (!function_exists('getStageField')) {
    function getStageField($field, $preview = null)
    {

        $data = '';
        $required = $field->is_required == '1' ? 'required' : '';
        $field_name = app()->getLocale() == "ar" ? $field->name_ar : $field->name_en;

        $first_name = app()->getLocale() == "en" ? 'first name' : 'الاسم الاول';
        $second_name = app()->getLocale() == "en" ? 'second name' : 'الاسم الثاني';
        $third_name = app()->getLocale() == "en" ? 'third name' : 'الاسم الثالث';
        $forth_name = app()->getLocale() == "en" ? 'forth name' : 'الاسم الرابع';

        if (isset($preview->fields)) {
            $preview_field = $preview->fields->where('id', $field->id)->first();


            // if field not required and the user did not submit it
            if (isset($preview_field)) {
                $field_data = $preview_field->pivot->data;
                $media_id = $preview_field->pivot->media_id;
            } else {
                $field_data = '';
                $media_id = null;
            }
        } else {
            $field_data = '';
            $media_id = null;
        }




        if ($field->type == 'name') {

            $field_data = explode(',', $field_data);


            $data = '

                    <div class="col-md-12 mt-3">
                        <label class="form-label">' .  $field_name . '</label>

                    </div>
                    <div class="col-md-3">
                        <input name="data[' . $field->id . '][]" class="form-control"
                            value="' . (isset($field_data[0]) ? $field_data[0] : '') . '" type="text" ' .  $required . ' placeholder="' .  $first_name . '" />
                    </div>
                    <div class="col-md-3">
                        <input name="data[' . $field->id . '][]" class="form-control"
                            value="' . (isset($field_data[1]) ? $field_data[1] : '') . '" type="text" ' .  $required . ' placeholder="' .  $second_name . '" />
                    </div>
                    <div class="col-md-3">
                        <input name="data[' . $field->id . '][]" class="form-control"
                            value="' . (isset($field_data[2]) ? $field_data[2] : '') . '" type="text" ' .  $required . ' placeholder="' .  $third_name . '" />
                    </div>
                    <div class="col-md-3">
                        <input name="data[' . $field->id . '][]" class="form-control"
                            value="' . (isset($field_data[3]) ? $field_data[3] : '') . '" type="text" ' .  $required . ' placeholder="' .  $forth_name . '" />
                    </div>';
        }


        if ($field->type == 'photo') {

            if ($media_id != null) {
                $media = Media::findOrFail($media_id);
                $path = asset($media->path);
                $required = '';
            } else {
                $path = '';
            }

            $data = '<div class="col-md-12 mt-3">
                        <label class="form-label">' .  $field_name . '</label>

                    </div>
                    <div class="mb-3">
                        <input name="data[' . $field->id . '][]" class="img form-control"
                            type="file" id="image" ' .  $required . ' />

                    </div>
                    <div class="mb-3">
                        <div class="col-md-10">
                            <img src="' . $path . '" style="width:100px; border: 1px solid #999"
                                class="img-thumbnail img-prev">
                        </div>
                    </div>';
        }

        if ($field->type == 'number') {

            $data = '<div class="col-md-12 mt-3">
                        <label class="form-label">' .  $field_name . '</label>

                    </div>
                    <div class="mb-3">
                        <input name="data[' . $field->id . '][]" class="form-control"
                        value="' . $field_data . '" type="number" ' .  $required . '  />
                    </div>
                    ';
        }

        if ($field->type == 'text') {

            $data = '<div class="col-md-12 mt-3">
                        <label class="form-label">' .  $field_name . '</label>

                    </div>
                    <div class="mb-3">
                        <input name="data[' . $field->id . '][]" class="form-control"
                        value="' . $field_data . '" type="text" ' .  $required . '  />
                    </div>
                    ';
        }


        if ($field->type == 'radio') {


            $options = explode(',', $field->data);
            $field_options = '';
            $field_data = explode(',', $field_data);


            foreach ($options as $option) {

                $field_options .= '<div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input" id="gender1"
                                        type="radio" name="data[' . $field->id . '][]" value="' . $option . '" ' .  $required . ' ' . (in_array($option, $field_data) ? 'checked' : '') . ' />
                                    <label class="form-check-label" for="">' . $option . '</label>
                                </div>';
            }

            $data = '<div class="col-md-12 mt-3">
                        <label class="form-label">' .  $field_name . '</label>
                    </div>

                    <div class="mb-3">' . $field_options . '</div>';
        }


        if ($field->type == 'checkbox') {


            $options = explode(',', $field->data);
            $field_options = '';
            $field_data = explode(',', $field_data);


            foreach ($options as $option) {

                $field_options .= '<div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input" id="gender1"
                                        type="checkbox" name="data[' . $field->id . '][]" value="' . $option . '" ' .  $required . ' ' . (in_array($option, $field_data) ? 'checked' : '') . ' />
                                    <label class="form-check-label" for="">' . $option . '</label>
                                </div>';
            }

            $data = '<div class="col-md-12 mt-3">
                        <label class="form-label">' .  $field_name . '</label>
                    </div>

                    <div class="mb-3">' . $field_options . '</div>';
        }


        return $data;
    }
}



// create order history
if (!function_exists('getAccountCode')) {
    function getAccountCode($account)
    {
        $last_account = $account->accounts->last();
        if ($last_account == null) {
            $code = $account->code . '01';
        } else {
            $code = $last_account->code + 1;
        }
        return $code;
    }
}


// create order history
if (!function_exists('getAccountName')) {
    function getAccountName($type, $item = null)
    {

        $name = [];

        switch ($type) {
            case 'assets_account':
                $name['ar'] = 'مخزون' . ' - ' . $item->name_ar;
                $name['en'] = $item->name_ar . ' - ' . 'inventory';
                break;

            case 'assets_account_sub':
                $name['ar'] = 'مخزون' . ' - ' . getProductName($item->product, $item, 'ar');
                $name['en'] = getProductName($item->product, $item, 'ar') . ' - ' . 'inventory';
                break;

            case 'cs_account':
                $name['ar'] = 'تكلفة البضاعة المباعة' . ' - ' . $item->name_ar;
                $name['en'] = $item->name_ar . ' - ' . 'cost of inventory';
                break;


            case 'cs_account_sub':
                $name['ar'] = 'تكلفة البضاعة المباعة' . ' - ' . getProductName($item->product, $item, 'ar');
                $name['en'] = getProductName($item->product, $item, 'ar') . ' - ' . 'cost of inventory';
                break;

            case 'suppliers_account':
                $name['ar'] = 'حساب مورد' . ' - ' . $item->name;
                $name['en'] = $item->name . ' - ' . 'supplier account';
                break;

            case 'employee_loan_account':
                $name['ar'] = 'حساب قروض' . ' - ' . $item->name;
                $name['en'] = $item->name . ' - ' . 'loan account';
                break;

            case 'petty_cash_account':
                $name['ar'] = 'حساب العهد النقدية' . ' - ' . $item->name;
                $name['en'] = $item->name . ' - ' . 'loan account';
                break;

            case 'staff_receivables_account':
                $name['ar'] = 'حساب ذمم' . ' - ' . $item->name;
                $name['en'] = $item->name . ' - ' . 'staff receivables account';
                break;

            case 'customers_account':
                if ($item) {
                    $name['ar'] = 'حساب عميل' . ' - ' . $item->name;
                    $name['en'] = $item->name . ' - ' . 'customer account';
                } else {
                    $name['ar'] = 'حساب عملاء غير مسجلين';
                    $name['en'] = 'not registered users account';
                }

                break;

            case 'revenue_account_services':
                $name['ar'] = 'ايراد' . ' - ' . $item->name_ar;
                $name['en'] = $item->name_ar . ' - ' . 'revenue';
                break;

            case 'revenue_account_services_sub':
                $name['ar'] = 'ايراد' . ' - ' . getProductName($item, null, 'ar');
                $name['en'] = getProductName($item, null, 'ar') . ' - ' . 'revenue';
                break;


            case 'revenue_account_products':
                $name['ar'] = 'ايراد' . ' - ' . $item->name_ar;
                $name['en'] = $item->name_ar . ' - ' . 'revenue';
                break;

            case 'revenue_account_products_sub':
                $name['ar'] = 'ايراد' . ' - ' . getProductName($item->product, $item, 'ar');
                $name['en'] = getProductName($item->product, $item, 'ar') . ' - ' . 'revenue';
                break;

            case 'revenue_account_shipping':
                $name['ar'] = 'ايراد من شحن المنتجات';
                $name['en'] = 'revenue from products shipping';
                break;

            default:
                # code...
                break;
        }

        return $name;
    }
}


// get item acount
if (!function_exists('getItemAccount')) {
    function getItemAccount($item, $parent, $type, $branch_id)
    {


        if ($type == 'revenue_account_services' || $type == 'revenue_account_products' || $type == 'revenue_account_shipping') {
            $main_account = Account::findOrFail(settingAccount('revenue_account', $branch_id));
        } else {
            $main_account = Account::findOrFail(settingAccount($type, $branch_id));
        }


        // create accounts for user with different roles
        if ($type == 'suppliers_account' || $type ==  'customers_account' || $type ==  'employee_loan_account' || $type ==  'staff_receivables_account' || $type ==  'petty_cash_account') {

            if ($item != null) {
                $user = User::findOrFail($item);
                $account = Account::where('reference_id', $user->id)->where('type', $type)->where('branch_id', $branch_id)->first();

                // if there is no account for the user
                if ($account == null) {

                    $code = getAccountCode($main_account);
                    $account_name = getAccountName($type, $user);

                    $account = Account::create([
                        'name_ar' => $account_name['ar'],
                        'name_en' => $account_name['en'],
                        'code' => $code,
                        'parent_id' => $main_account->id,
                        'account_type' => $main_account->account_type,
                        'reference_id' =>  $user->id,
                        'type' => $type,
                        'branch_id' => $branch_id,
                        'created_by' => Auth::id(),
                    ]);
                }
            } else {

                // create customer account == null when make fast order (for not registered users)
                $account = Account::where('reference_id', null)->where('type', $type)->where('branch_id', $branch_id)->first();

                if ($account == null) {

                    $code = getAccountCode($main_account);
                    $account_name = getAccountName($type, null);

                    $account = Account::create([
                        'name_ar' => $account_name['ar'],
                        'name_en' => $account_name['en'],
                        'code' => $code,
                        'parent_id' => $main_account->id,
                        'account_type' => $main_account->account_type,
                        'reference_id' =>  null,
                        'type' => $type,
                        'branch_id' => $branch_id,
                        'created_by' => Auth::id(),
                    ]);
                }
            }
        } elseif ($type == 'revenue_account_shipping') {

            $account = Account::where('reference_id', null)->where('type', $type)->where('branch_id', $branch_id)->first();

            if ($account == null) {

                $code = getAccountCode($main_account);
                $account_name = getAccountName($type, null);

                $account = Account::create([
                    'name_ar' => $account_name['ar'],
                    'name_en' => $account_name['en'],
                    'code' => $code,
                    'parent_id' => $main_account->id,
                    'account_type' => $main_account->account_type,
                    'reference_id' =>  null,
                    'type' => $type,
                    'branch_id' => $branch_id,
                    'created_by' => Auth::id(),
                ]);
            }
        } else {

            $parent_account = Account::where('reference_id', $parent->id)->where('type', $type)->where('branch_id', $branch_id)->first();

            if ($parent_account == null) {

                $code = getAccountCode($main_account);
                $account_name = getAccountName($type, $parent);

                $parent_account = Account::create([
                    'name_ar' => $account_name['ar'],
                    'name_en' => $account_name['en'],
                    'code' => $code,
                    'parent_id' => $main_account->id,
                    'account_type' => $main_account->account_type,
                    'reference_id' =>  $parent->id,
                    'type' => $type,
                    'branch_id' => $branch_id,
                    'created_by' => Auth::id(),
                ]);
            }

            $new_type = $type . '_sub';

            $account = Account::where('reference_id', $item->id)->where('type', $new_type)->where('parent_id', $parent_account->id)->first();

            if ($account == null) {


                $code = getAccountCode($parent_account);
                $account_name = getAccountName($new_type, $item);


                $account = Account::create([
                    'name_ar' => $account_name['ar'],
                    'name_en' => $account_name['en'],
                    'code' => $code,
                    'parent_id' => $parent_account->id,
                    'account_type' => $parent_account->account_type,
                    'reference_id' =>  $item->id,
                    'type' => $new_type,
                    'branch_id' => $branch_id,
                    'created_by' => Auth::id(),
                ]);
            }
        }




        return $account;
    }
}


if (!function_exists('checkPer')) {
    function checkPer($pers)
    {
        $check = false;

        foreach ($pers as $per) {
            if (Auth::user()->hasPermission($per . '-read')) {
                $check = true;
            }
        }

        return $check;
    }
}







if (!function_exists('getOrderDue')) {
    function getOrderDue($order)
    {

        $branch_id = $order->branch_id;
        $amount = 0;


        if ($order->order_from == 'addpurchase') {

            $account = getItemAccount($order->customer_id, null, 'suppliers_account', $branch_id);
            $entries = Entry::where('reference_id', $order->id)->where('type', 'purchase')->where('account_id', $account->id)->get();

            foreach ($entries as $entry) {
                $amount -= $entry->dr_amount;
                $amount += $entry->cr_amount;
            }
        }

        if ($order->order_from == 'addsale') {

            $account = getItemAccount($order->customer_id, null, 'customers_account', $branch_id);
            $entries = Entry::where('reference_id', $order->id)->where('type', 'sales')->where('account_id', $account->id)->get();

            foreach ($entries as $entry) {
                $amount += $entry->dr_amount;
                $amount -= $entry->cr_amount;
            }
        }

        return $amount;
    }
}


if (!function_exists('getTotalPayments')) {
    function getTotalPayments($order)
    {

        $branch_id = $order->branch_id;
        $amount = 0;

        if ($order->order_from == 'addpurchase') {

            $account = getItemAccount($order->customer_id, null, 'suppliers_account', $branch_id);

            $entries = Entry::where('reference_id', $order->id)->where('type', 'pay_purchase')->where('account_id', $account->id)->get();

            foreach ($entries as $entry) {
                $amount += $entry->dr_amount;
                $amount -= $entry->cr_amount;
            }
        }


        if ($order->order_from == 'addsale') {

            $account = getItemAccount($order->customer_id, null, 'customers_account', $branch_id);

            $entries = Entry::where('reference_id', $order->id)->where('type', 'pay_sales')->where('account_id', $account->id)->get();

            foreach ($entries as $entry) {
                $amount -= $entry->dr_amount;
                $amount += $entry->cr_amount;
            }
        }

        return $amount;
    }
}


if (!function_exists('createEntry')) {
    function createEntry($account, $type, $dr_amount, $cr_amount, $branch_id, $reference, $due_date = null)
    {
        Entry::create([
            'account_id' => $account->id,
            'type' => $type,
            'dr_amount' => $dr_amount,
            'cr_amount' => $cr_amount,
            'description' => getEntryDes($type, $reference),
            'branch_id' => $branch_id,
            'reference_id' => $reference->id,
            'created_by' => Auth::id(),
            'due_date' => $due_date
        ]);
    }
}


// create order history
if (!function_exists('getEntryDes')) {
    function getEntryDes($type, $reference = null)
    {

        $des = '';

        switch ($type) {
            case 'pay_purchase':
                $des = 'pay for purchase invoice' . ' - ' . 'دفع لفاتورة مشتريات' . ' - #'  . $reference->id;
                break;

            case 'pay_sales':
                $des = 'pay for sales invoice' . ' - ' . 'دفع لفاتورة مبيعات' . ' - #'  . $reference->id;
                break;

            case 'sales':
                $des = 'sales order' . ' - ' . 'طلب مبيعات' . ' - #'  . $reference->id;
                break;

            case 'purchase':
                $des = 'purchase order' . ' - ' . 'طلب مشتريات' . ' - #'  . $reference->id;
                break;

            case 'sales_return':
                $des = 'sales return' . ' - ' . 'مرتجع مبيعات' . ' - #'  . $reference->id;
                break;

            case 'purchase_return':
                $des = 'purchase return' . ' - ' . 'مرتجع مشتريات' . ' - #'  . $reference->id;
                break;

            default:
                # code...
                break;
        }

        return $des;
    }
}



// get website warehouses
if (!function_exists('getWebsiteWarehouses')) {
    function getWebsiteWarehouses()
    {

        $branch = setting('website_branch');
        $branch = Branch::find($branch);

        if ($branch) {

            $warehouses = Warehouse::where('branch_id', $branch->id)
                ->where('vendor_id', null)
                ->get()->pluck('id')->toArray();
        } else {
            $warehouses = [];
        }


        return $warehouses;
    }
}


// get website warehouse for order
if (!function_exists('getWarehousForOrder')) {
    function getWarehousForOrder($branch_id, $city_id, $combination, $qty)
    {


        $branch = Branch::find($branch_id);
        $warehouses = $branch->warehouses->where('city_id', $city_id);



        foreach ($warehouses as $warehouse) {
            $av_qty = productQuantityWebsite($combination->product->id, $combination->id, $warehouse->id, null);
            if ($av_qty >= $qty) {
                return $warehouse;
            }
        }

        $warehouses = $branch->warehouses;



        foreach ($warehouses as $index => $warehouse) {
            $av_qty = productQuantity($combination->product->id, $combination->id, $warehouse->id, null);
            if ($av_qty >= $qty) {
                return $warehouse;
            }
        }
    }
}









// check accounts
if (!function_exists('getProductCost')) {
    function getProductCost($product, $combination, $branch_id, $ref_order, $qty, $returned)
    {

        $cost = 0;

        if ($returned == false) {
            if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                $cost = $combination->costs->where('branch_id', $branch_id)->first()->cost;
            } else {
                $cost = $product->cost;
            }
        } else {
            if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                $ref_product =  $ref_order->products()->wherePivot('product_id', $product->id)->wherePivot('product_combination_id', $combination->id)->first();
                $cost = $ref_product->pivot->cost;
                updateCost($combination, $cost, $qty, 'add', $branch_id);
            } else {
                $ref_product =  $ref_order->products()->wherePivot('product_id', $product->id)->first();
                $cost = $ref_product->pivot->cost;
            }
        }

        return $cost;
    }
}






// stock create
if (!function_exists('getCombinations')) {
    function getCombinations($arrays, $i = 0)
    {

        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = getCombinations($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }




        return $result;
    }
}



// get countries
if (!function_exists('getCountries')) {
    function getCountries()
    {
        $countries = Country::all();
        return $countries;
    }
}







// calculate coupon discount
if (!function_exists('getWhatsappButton')) {
    function getWhatsappButton()
    {


        $tag = '';

        $url = url()->current();

        $text = app()->getLocale() == 'ar' ? 'مرحبا, اريد الاستفسار عن هذا المنتج' : 'Hello, I want to inquire about this product';

        $phone = websiteSettingAr('whatsapp_phone');

        $tag .= '<a href="https://api.whatsapp.com/send?phone=' . $phone . '&text=' . $text . ' - ' . $url . '" class="float"
                    target="_blank">
                    <i class="fa fa-whatsapp my-float"></i>
                </a>';

        return $tag;
    }
}


// calculate coupon discount
if (!function_exists('getWhatsappCart')) {
    function getWhatsappCart($user)
    {





        $url = route('ecommerce.cart');
        $base_url = url('/');


        $text = $user->lang == 'ar' ? 'مرحبا' . ' ' . $user->name . ', ' . 'شكرا لزيارة موقعنا ' . $base_url . ' ' . 'هل تواجه اي مشكلة في اتمام طلبك ؟ - يمكنك من تكملة عميلة الشراء من الرابط التالي ' : 'Hello' . ' ' . $user->name . ', ' . 'thank you for visiting our website' . ' ' . $base_url . 'Are you facing any problem in completing your order? - You can complete your purchase from the following link';

        $phone = $user->phone;

        $button_text = __('send whatsapp');

        $tag = '<a class="btn btn-success btn-sm me-1 mb-1" href="https://api.whatsapp.com/send?phone=' . $phone . '&text=' . $text . ' - ' . $url . '" class="float"
                    target="_blank">
                    ' . $button_text . '
                </a>';

        return $tag;
    }
}


// getTopCollections
if (!function_exists('getTopCollections')) {
    function getTopCollections()
    {
        $country = getCountry();
        $warehouses = getWebsiteWarehouses();

        $products = Product::where('status', "active")
            ->where('country_id', $country->id)
            ->where('top_collection', '1')
            ->where(function ($query) use ($warehouses) {
                $query->whereHas('stocks', function ($query) use ($warehouses) {
                    $query->whereIn('warehouse_id', $warehouses);
                })->orWhereIn('product_type', ['digital', 'service'])
                    ->orWhereNotNull('vendor_id');
            })
            ->inRandomOrder()
            ->limit(15)
            ->get();


        return $products;
    }
}



// best_selling
if (!function_exists('getBestSelling')) {
    function getBestSelling()
    {
        $country = getCountry();
        $warehouses = getWebsiteWarehouses();


        $products = Product::where('status', "active")
            ->where('country_id', $country->id)
            ->where('best_selling', '1')
            ->where(function ($query) use ($warehouses) {
                $query->whereHas('stocks', function ($query) use ($warehouses) {
                    $query->whereIn('warehouse_id', $warehouses);
                })->orWhereIn('product_type', ['digital', 'service'])
                    ->orWhereNotNull('vendor_id');
            })
            ->inRandomOrder()
            ->limit(15)
            ->get();


        return $products;
    }
}



// is_featured
if (!function_exists('getIsFeatured')) {
    function getIsFeatured()
    {
        $country = getCountry();
        $warehouses = getWebsiteWarehouses();

        $products = Product::where('status', "active")
            ->where('country_id', $country->id)
            ->where('is_featured', '1')
            ->where(function ($query) use ($warehouses) {
                $query->whereHas('stocks', function ($query) use ($warehouses) {
                    $query->whereIn('warehouse_id', $warehouses);
                })->orWhereIn('product_type', ['digital', 'service'])
                    ->orWhereNotNull('vendor_id');
            })
            ->inRandomOrder()
            ->limit(15)
            ->get();

        return $products;
    }
}



// on_sale
if (!function_exists('getOnSale')) {
    function getOnSale()
    {
        $country = getCountry();
        $warehouses = getWebsiteWarehouses();

        $products = Product::where('status', "active")
            ->where('country_id', $country->id)
            ->where('on_sale', '1')
            ->where(function ($query) use ($warehouses) {
                $query->whereHas('stocks', function ($query) use ($warehouses) {
                    $query->whereIn('warehouse_id', $warehouses);
                })->orWhereIn('product_type', ['digital', 'service'])
                    ->orWhereNotNull('vendor_id');
            })
            ->inRandomOrder()
            ->limit(15)
            ->get();

        return $products;
    }
}


// get item
if (!function_exists('getItemById')) {
    function getItemById($id, $type)
    {

        if ($type == 'product') {
            $item = Product::findOrFail($id);
        }

        if ($type == 'category') {
            $item = Category::findOrFail($id);
        }

        return $item;
    }
}


// get item
if (!function_exists('addToCart')) {
    function addToCart($product_id, $qty, $user_id = null, $product_combination_id = null, $session_id = null)
    {

        if (setting('snapchat_pixel_id') && setting('snapchat_token')) {
            snapchatEvent('ADD_CART');
        }

        if (setting('facebook_id') && setting('facebook_token')) {
            facebookEvent('AddToCart');
        }


        CartItem::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'qty' => $qty,
            'product_combination_id' => $product_combination_id,
            'session_id' => $session_id
        ]);
    }
}








// get testimonial stars
if (!function_exists('getTistimonialStars')) {
    function getTistimonialStars($testimonial)
    {



        $rating = $testimonial->rating;
        $result = '';

        if ($rating > 5) {
            $rating = 5;
        }




        for ($i = 0; $i < $rating; $i++) {
            $result .= '<i class="fa fa-star"></i>';
        }

        $remaining = 5 - $rating;



        if ($remaining != 0) {
            for ($i = 0; $i < $remaining; $i++) {
                $result .= '<i style="color: #ddd;" class="fa fa-star"></i>';
            }
        }

        return $result;
    }
}


// create snap chat event
if (!function_exists('snapchatEvent')) {
    function snapchatEvent($type)
    {

        $capi = new ConversionApi(setting('snapchat_token'));

        // Please use the following line if the LaunchPad is available.
        // $capi = new ConversionApi(API_TOKEN, LAUNCH_PAD_URL);

        // (Optional) Enable logging
        // $capi->setDebugging(true);

        $date = Carbon::now()->timestamp;

        // $date = $date->toDateString();

        $ip =  request()->ip();
        $device = strval(request()->userAgent());
        $url = request()->url();
        $phone = null;

        if (Auth::check()) {
            $phone = Auth::user()->phone;
        }


        // Use Case 1: Send an event asynchronously
        $capiEvent1 = (new CapiEvent())
            ->setPixelId(setting('snapchat_pixel_id'))
            ->setEventConversionType('WEB')
            ->setEventType($type)
            ->setTimestamp($date)
            // The following PII fields are hashed by SHA256 before being sent to CAPI.
            // Alternatively, you can use hashed-field setters (e.g. setHashedEmail()) to set the hashed value directly.
            // ->setEmail('mocking-email')
            ->setPageUrl($url)
            ->setPhoneNumber($phone)
            ->setUserAgent($device)
            ->setIpAddress($ip);
        // ->setPhoneNumber('mocking-phone-num');

        $capi->sendEvent($capiEvent1);
        // $response1 = $capi->sendTestEvent($capiEvent1);
        // dd(implode($response1));
    }
}


// create snap chat event
if (!function_exists('facebookEvent')) {
    function facebookEvent($type, $value = 0, $currency = '')
    {

        $pixel_id = setting('facebook_id');
        $access_token = setting('facebook_token');


        $date = Carbon::now()->timestamp;
        $ip =  request()->ip();
        $device = strval(request()->userAgent());
        $url = request()->url();
        $phone = null;

        if (Auth::check()) {
            $phone = Auth::user()->phone;
        }



        $result = Api::init(null, null, $access_token, false);



        $user_data = (new UserData())
            ->setClientIpAddress($ip)
            ->setClientUserAgent($device)
            ->setPhone($phone);

        if ($value > 0) {
            $custom_data = (new CustomData())
                // ->setContents(array($content))
                ->setCurrency($currency)
                ->setValue($value);
        }



        $event = (new Event())
            ->setEventName($type)
            ->setEventTime($date)
            ->setEventSourceUrl($url)
            ->setUserData($user_data)
            ->setCustomData(isset($custom_data) ? $custom_data : null)
            // ->setCustomData($custom_data)
            ->setActionSource('website ');

        $event = array($event);


        // $request = (new EventRequest($pixel_id))
        //     ->setTestEventCode('TEST12345')
        //     ->setEvents($event);

        // $response = $request->execute();

        $async_request = (new EventRequestAsync($pixel_id))
            ->setEvents($event);
        $fRequest = $async_request->execute()
            ->then(
                null,
                function (RequestException $e) {
                    print("Error!!!\n" .
                        $e->getMessage() . "\n" .
                        $e->getRequest()->getMethod() . "\n"
                    );
                }
            );

        // Async request:
        $promise = $fRequest;

        // dd($promise);
    }
}


// add view record
if (!function_exists('addViewRecord')) {
    function addViewRecord()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $session_id = null;
        } else {
            $user_id = null;
            $session_id = request()->session()->token();
        }

        $ip =  request()->ip();
        $position = Location::get($ip);

        if ($position) {
            $countryName = $position->countryName;
            $regionName = $position->regionName;
            $cityName = $position->cityName;
        } else {
            $countryName = null;
            $regionName = null;
            $cityName = null;
        }

        $device = strval(request()->userAgent());


        $view = View::create([
            'user_id' => $user_id,
            'session_id' => $session_id,
            'ip' => $ip,
            'url' => request()->url(),
            'full_url' => request()->fullUrl(),
            'country_name' => $countryName,
            'state_name' => $regionName,
            'city_name' => $cityName,
            'device' => $device,

        ]);
    }
}



// get user cash accounts

if (!function_exists('getCashAccounts')) {
    function getCashAccounts()
    {
        $user = Auth::user();
        $branch_id = getUserBranchId($user);
        $cash_accounts = $user->accounts->where('type', 'cash_accounts')->where('parent_id', settingAccount('cash_accounts', $branch_id));
        if ($cash_accounts == null) {
            $cash_accounts = [];
        }
        return $cash_accounts;
    }
}



if (!function_exists('getUserAttendance')) {
    function getUserAttendance()
    {
        $user = Auth::user();
        $date = Carbon::now();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('attendance_date', '=', $date)
            ->whereNotNull('attendance_date')
            ->first();

        return $attendance;
    }
}


if (!function_exists('getUserLeave')) {
    function getUserLeave()
    {
        $user = Auth::user();
        $date = Carbon::now();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('leave_date', '=', $date)
            ->whereNotNull('leave_date')
            ->first();

        return $attendance;
    }
}



if (!function_exists('getUserSalary')) {
    function getUserSalary($user)
    {
        $employee_info = getEmployeeInfo($user);

        if ($employee_info) {
            $salary = ($employee_info->basic_salary + $employee_info->variable_salary);
        } else {
            $salary = 0;
        }

        return $salary;
    }
}

if (!function_exists('getUserDaySalary')) {
    function getUserDaySalary($user)
    {
        $employee_info = getEmployeeInfo($user);

        if ($employee_info) {
            $day_salary = ((($employee_info->basic_salary + $employee_info->variable_salary) * 12) / 365);
            $day_salary = round($day_salary, 2);
        } else {
            $day_salary = 0;
        }

        return $day_salary;
    }
}


if (!function_exists('getUserAbsenceDays')) {
    function getUserAbsenceDays($user, $date)
    {
        $employee_info = getEmployeeInfo($user);

        $start = Carbon::parse($date)->startOfMonth();
        $end = Carbon::parse($date)->endOfMonth();
        $dates = [];
        while ($start->lte($end)) {
            $dates[$start->toDateString()] = $start->format('D');
            $start->addDay();
        }

        $weekend_days = ($employee_info->Weekend_days &&
            is_array(unserialize($employee_info->Weekend_days))) ? unserialize($employee_info->Weekend_days) : [];

        $absence_days = 0;
        foreach ($dates as $key => $date) {

            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('attendance_date', '=', $key)
                ->whereNotNull('attendance_date')
                ->first();

            $leave = Attendance::where('user_id', $user->id)
                ->whereDate('leave_date', '=', $key)
                ->whereNotNull('leave_date')
                ->first();

            $permission = EmployeePermission::where('user_id', $user->id)
                ->where('status', 'confirmed')
                ->where('type', 'vacation')
                ->whereDate('date', '=', $key)
                ->first();

            if (!in_array($date, $weekend_days) && ($attendance == null || $leave == null)) {
                if ($permission == null) {
                    $absence_days++;
                }
            }
        }

        return $absence_days;
    }
}



if (!function_exists('getUserPenalties')) {
    function getUserPenalties($user, $date)
    {

        $month = Carbon::parse($date)->format('m');
        $year = Carbon::parse($date)->format('Y');

        $penalties = Reward::where('user_id', $user->id)
            ->where('type', 'penalty')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->get();

        $penalties_amount = 0;
        foreach ($penalties as $penalty) {
            $penalties_amount += $penalty->amount;
        }

        return $penalties_amount;
    }
}


if (!function_exists('getUserRewards')) {
    function getUserRewards($user, $date)
    {

        $month = Carbon::parse($date)->format('m');
        $year = Carbon::parse($date)->format('Y');

        $rewards = Reward::where('user_id', $user->id)
            ->where('type', 'reward')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->get();

        $rewards_amount = 0;
        foreach ($rewards as $reward) {
            $rewards_amount += $reward->amount;
        }

        return $rewards_amount;
    }
}


if (!function_exists('getUserLoans')) {
    function getUserLoans($user)
    {
        $branch_id = getUserBranchId($user);
        $loans_account = getItemAccount($user->id, null, 'employee_loan_account', $branch_id);
        $loans =  getTrialBalance($loans_account->id, null, null);

        return $loans;
    }
}


if (!function_exists('getSalaryCard')) {
    function getSalaryCard($user, $date)
    {
        $salary_card = SalaryCard::where('user_id', $user->id)
            ->where('date', $date)
            ->first();
        return $salary_card;
    }
}



if (!function_exists('getSettlementAmount')) {
    function getSettlementAmount($user)
    {
        $sheets = SettlementSheet::where('user_id', $user->id)->where('status', 'pending')->get();
        $amount = 0;

        foreach ($sheets as $sheet) {
            $amount += $sheet->amount;
        }

        return $amount;
    }
}


if (!function_exists('getSettlementAmountForSheet')) {
    function getSettlementAmountForSheet($sheet)
    {
        $records = $sheet->records;
        $amount = 0;

        foreach ($records as $record) {
            $amount += $record->amount;
        }

        return $amount;
    }
}


if (!function_exists('isMobileDevice')) {
    function isMobileDevice()
    {
        return preg_match('/Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i', $_SERVER['HTTP_USER_AGENT']);
    }
}



if (!function_exists('getLateTime')) {
    function getLateTime($attendance)
    {

        $late_time = 0;
        $employee_info = getEmployeeInfo($attendance->user);

        if ($attendance->start_time != null) {
            $start_time = $attendance->start_time;
        } else {
            $start_time = $employee_info->start_time;
            $attendance->update([
                'start_time' => $start_time,
            ]);
        }

        if ($employee_info) {
            if ($attendance->attendance_date != null) {
                $attendance_time = Carbon::parse($attendance->attendance_date);
                $start_time = Carbon::parse($start_time);

                if ($attendance_time->gt($start_time)) {
                    $late_time = $attendance_time->diffInMinutes($start_time);

                    $allow_time = setting('allow_employees') ? setting('allow_employees') : 0;
                    if ($late_time <= $allow_time) {
                        $late_time = 0;
                    }
                }

                // dd($attendance_time->diffInRealMinutes($start_time), $attendance_time->toTimeString(), $start_time->toTimeString(), $late_time);
            } else {
                $leave_time =  Carbon::parse($attendance->leave_date);
                $working_hours =  $employee_info->work_hours;
                $official_leave_time = Carbon::parse($start_time)->addHours($working_hours);


                if ($official_leave_time->gt($leave_time)) {
                    $late_time = $official_leave_time->diffInMinutes($leave_time);
                }

                // dd($official_leave_time->toDateTimeString(), $leave_time->toDateTimeString(), $late_time);
            }
        }


        return $late_time;
    }
}
