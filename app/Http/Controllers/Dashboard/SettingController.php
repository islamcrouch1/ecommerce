<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Country;
use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\Tax;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        $settings = Setting::all();
        $countries = Country::all();
        $shipping_methods = ShippingMethod::all();
        $assets_accounts = Account::where('account_type', 'assets')->get();
        $taxes = Tax::all();
        $liability_accounts = Account::where('account_type', 'liability')->get();
        $revenue_accounts = Account::where('account_type', 'revenue')->get();
        $expenses_accounts = Account::where('account_type', 'expenses')->get();
        return view('dashboard.settings.index', compact('settings', 'warehouses', 'countries', 'shipping_methods', 'assets_accounts', 'taxes', 'liability_accounts', 'revenue_accounts', 'expenses_accounts'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'max_price' => "required|numeric",
            'tax' => "required|numeric",
            'commission' => "required|numeric",
            'affiliate_limit' => "required|numeric",
            'vendor_limit' => "required|numeric",
            'mandatory_affiliate' => "required|numeric",
            'mandatory_vendor' => "required|numeric",
            'terms_ar' => "required|string",
            'terms_en' => "required|string",
            'front_modal' => "nullable",
            'affiliate_modal' => "nullable",
            'vendor_modal' => "nullable",
            'front_modal_title' => "nullable|string",
            'front_modal_body' => "nullable|string",
            'affiliate_modal_title' => "nullable|string",
            'affiliate_modal_body' => "nullable|string",
            'vendor_modal_title' => "nullable|string",
            'vendor_modal_body' => "nullable|string",
            'compression_ratio' => "required|numeric|max:100|min:20",
            'warehouse_id' => "nullable|string",
            'country_id' => "nullable|string",
            'shipping_method' => "nullable|string",
            'locale_pickup' => "nullable|string",
            'assets_account' => "nullable|string",
            'suppliers_account' => "nullable|string",
            'wht_products' => "nullable|numeric",
            'vat' => "nullable|numeric",
            'wht_invoice_amount' => "nullable|numeric",
            'vat_purchase_account' => "nullable|numeric",
            'wct_account' => "nullable|numeric",
            'revenue_account' => "nullable|numeric",
            'vat_sales_account' => "nullable|numeric",
            'account_receivable_account' => "nullable|numeric",
            'wst_account' => "nullable|numeric",
            'cash_account' => "nullable|numeric",
            'card_account' => "nullable|numeric",
            'income_tax' => "nullable|numeric",
            'expenses_account' => "nullable|numeric",
            'wht_services' => "nullable|numeric",
        ]);


        $setting = Setting::where('type', 'wht_services')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'wht_services',
                'value' => $request['wht_services'],
            ]);
        } else {
            $setting->update([
                'value' => $request['wht_services'],
            ]);
        }

        $setting = Setting::where('type', 'expenses_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'expenses_account',
                'value' => $request['expenses_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['expenses_account'],
            ]);
        }


        $setting = Setting::where('type', 'income_tax')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'income_tax',
                'value' => $request['income_tax'],
            ]);
        } else {
            $setting->update([
                'value' => $request['income_tax'],
            ]);
        }

        $setting = Setting::where('type', 'cash_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'cash_account',
                'value' => $request['cash_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['cash_account'],
            ]);
        }

        $setting = Setting::where('type', 'card_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'card_account',
                'value' => $request['card_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['card_account'],
            ]);
        }

        $setting = Setting::where('type', 'wst_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'wst_account',
                'value' => $request['wst_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['wst_account'],
            ]);
        }

        $setting = Setting::where('type', 'account_receivable_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'account_receivable_account',
                'value' => $request['account_receivable_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['account_receivable_account'],
            ]);
        }

        $setting = Setting::where('type', 'vat_sales_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'vat_sales_account',
                'value' => $request['vat_sales_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['vat_sales_account'],
            ]);
        }

        $setting = Setting::where('type', 'revenue_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'revenue_account',
                'value' => $request['revenue_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['revenue_account'],
            ]);
        }

        $setting = Setting::where('type', 'wct_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'wct_account',
                'value' => $request['wct_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['wct_account'],
            ]);
        }

        $setting = Setting::where('type', 'vat_purchase_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'vat_purchase_account',
                'value' => $request['vat_purchase_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['vat_purchase_account'],
            ]);
        }

        $setting = Setting::where('type', 'wht_invoice_amount')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'wht_invoice_amount',
                'value' => $request['wht_invoice_amount'],
            ]);
        } else {
            $setting->update([
                'value' => $request['wht_invoice_amount'],
            ]);
        }

        $setting = Setting::where('type', 'vat')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'vat',
                'value' => $request['vat'],
            ]);
        } else {
            $setting->update([
                'value' => $request['vat'],
            ]);
        }

        $setting = Setting::where('type', 'wht_products')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'wht_products',
                'value' => $request['wht_products'],
            ]);
        } else {
            $setting->update([
                'value' => $request['wht_products'],
            ]);
        }

        $setting = Setting::where('type', 'suppliers_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'suppliers_account',
                'value' => $request['suppliers_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['suppliers_account'],
            ]);
        }




        $setting = Setting::where('type', 'assets_account')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'assets_account',
                'value' => $request['assets_account'],
            ]);
        } else {
            $setting->update([
                'value' => $request['assets_account'],
            ]);
        }

        $setting = Setting::where('type', 'locale_pickup')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'locale_pickup',
                'value' => $request['locale_pickup'],
            ]);
        } else {
            $setting->update([
                'value' => $request['locale_pickup'],
            ]);
        }



        $setting = Setting::where('type', 'country_id')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'country_id',
                'value' => $request['country_id'],
            ]);
        } else {
            $setting->update([
                'value' => $request['country_id'],
            ]);
        }

        $countries = Country::all();
        foreach ($countries as $country) {
            $country->update([
                'is_default' => $country->id == $request['country_id'] ? '1' : '0'
            ]);
        }



        $setting = Setting::where('type', 'shipping_method')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'shipping_method',
                'value' => $request['shipping_method'],
            ]);
        } else {
            $setting->update([
                'value' => $request['shipping_method'],
            ]);
        }


        $setting = Setting::where('type', 'warehouse_id')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'warehouse_id',
                'value' => $request['warehouse_id'],
            ]);
        } else {
            $setting->update([
                'value' => $request['warehouse_id'],
            ]);
        }


        $setting = Setting::where('type', 'max_price')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'max_price',
                'value' => $request['max_price'],
            ]);
        } else {
            $setting->update([
                'value' => $request['max_price'],
            ]);
        }

        $setting = Setting::where('type', 'tax')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'tax',
                'value' => $request['tax'],
            ]);
        } else {
            $setting->update([
                'value' => $request['tax'],
            ]);
        }

        $setting = Setting::where('type', 'compression_ratio')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'compression_ratio',
                'value' => $request['compression_ratio'],
            ]);
        } else {
            $setting->update([
                'value' => $request['compression_ratio'],
            ]);
        }


        $setting = Setting::where('type', 'commission')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'commission',
                'value' => $request['commission'],
            ]);
        } else {
            $setting->update([
                'value' => $request['commission'],
            ]);
        }


        $setting = Setting::where('type', 'affiliate_limit')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'affiliate_limit',
                'value' => $request['affiliate_limit'],
            ]);
        } else {
            $setting->update([
                'value' => $request['affiliate_limit'],
            ]);
        }


        $setting = Setting::where('type', 'vendor_limit')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'vendor_limit',
                'value' => $request['vendor_limit'],
            ]);
        } else {
            $setting->update([
                'value' => $request['vendor_limit'],
            ]);
        }

        $setting = Setting::where('type', 'mandatory_affiliate')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'mandatory_affiliate',
                'value' => $request['mandatory_affiliate'],
            ]);
        } else {
            $setting->update([
                'value' => $request['mandatory_affiliate'],
            ]);
        }


        $setting = Setting::where('type', 'mandatory_vendor')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'mandatory_vendor',
                'value' => $request['mandatory_vendor'],
            ]);
        } else {
            $setting->update([
                'value' => $request['mandatory_vendor'],
            ]);
        }

        $setting = Setting::where('type', 'terms_ar')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'terms_ar',
                'value' => $request['terms_ar'],
            ]);
        } else {
            $setting->update([
                'value' => $request['terms_ar'],
            ]);
        }

        $setting = Setting::where('type', 'terms_en')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'terms_en',
                'value' => $request['terms_en'],
            ]);
        } else {
            $setting->update([
                'value' => $request['terms_en'],
            ]);
        }

        $setting = Setting::where('type', 'front_modal')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'front_modal',
                'value' => $request['front_modal'],
            ]);
        } else {
            $setting->update([
                'value' => $request['front_modal'],
            ]);
        }

        $setting = Setting::where('type', 'affiliate_modal')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'affiliate_modal',
                'value' => $request['affiliate_modal'],
            ]);
        } else {
            $setting->update([
                'value' => $request['affiliate_modal'],
            ]);
        }

        $setting = Setting::where('type', 'vendor_modal')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'vendor_modal',
                'value' => $request['vendor_modal'],
            ]);
        } else {
            $setting->update([
                'value' => $request['vendor_modal'],
            ]);
        }




        $setting = Setting::where('type', 'front_modal_title')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'front_modal_title',
                'value' => $request['front_modal_title'],
            ]);
        } else {
            $setting->update([
                'value' => $request['front_modal_title'],
            ]);
        }

        $setting = Setting::where('type', 'front_modal_body')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'front_modal_body',
                'value' => $request['front_modal_body'],
            ]);
        } else {
            $setting->update([
                'value' => $request['front_modal_body'],
            ]);
        }



        $setting = Setting::where('type', 'affiliate_modal_title')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'affiliate_modal_title',
                'value' => $request['affiliate_modal_title'],
            ]);
        } else {
            $setting->update([
                'value' => $request['affiliate_modal_title'],
            ]);
        }

        $setting = Setting::where('type', 'affiliate_modal_body')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'affiliate_modal_body',
                'value' => $request['affiliate_modal_body'],
            ]);
        } else {
            $setting->update([
                'value' => $request['affiliate_modal_body'],
            ]);
        }

        $setting = Setting::where('type', 'vendor_modal_title')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'vendor_modal_title',
                'value' => $request['vendor_modal_title'],
            ]);
        } else {
            $setting->update([
                'value' => $request['vendor_modal_title'],
            ]);
        }

        $setting = Setting::where('type', 'vendor_modal_body')->first();
        if ($setting == null) {
            Setting::create([
                'type' => 'vendor_modal_body',
                'value' => $request['vendor_modal_body'],
            ]);
        } else {
            $setting->update([
                'value' => $request['vendor_modal_body'],
            ]);
        }

        // Image::make($request->image)->resize(300, null, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->save(public_path('storage/images/countries/' . $request->image->hashName()), 80);

        alertSuccess('Settings saved successfully', 'تم حفظ الإعدادات بنجاح');
        return redirect()->route('settings.index');
    }
}
