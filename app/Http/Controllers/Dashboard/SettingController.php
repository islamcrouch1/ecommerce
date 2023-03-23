<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\Tax;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $user = Auth::user();

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        return view('dashboard.settings.index', compact('branches', 'settings', 'warehouses', 'countries', 'shipping_methods', 'assets_accounts', 'taxes', 'liability_accounts', 'revenue_accounts', 'expenses_accounts'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'max_price' => "nullable|numeric",
            'tax' => "nullable|numeric",
            'commission' => "nullable|numeric",
            'affiliate_limit' => "nullable|numeric",
            'vendor_limit' => "nullable|numeric",
            'mandatory_affiliate' => "nullable|numeric",
            'mandatory_vendor' => "nullable|numeric",
            'terms_ar' => "nullable|string",
            'terms_en' => "nullable|string",
            'front_modal' => "nullable",
            'affiliate_modal' => "nullable",
            'vendor_modal' => "nullable",
            'front_modal_title' => "nullable|string",
            'front_modal_body' => "nullable|string",
            'affiliate_modal_title' => "nullable|string",
            'affiliate_modal_body' => "nullable|string",
            'vendor_modal_title' => "nullable|string",
            'vendor_modal_body' => "nullable|string",
            'compression_ratio' => "nullable|numeric|max:100|min:20",
            // 'warehouse_id' => "nullable|string",
            'country_id' => "nullable|string",
            'shipping_method' => "nullable|string",
            'locale_pickup' => "nullable|string",
            'assets_account' => "nullable|array",
            'suppliers_account' => "nullable|array",
            'wht_products' => "nullable|numeric",
            'vat' => "nullable|numeric",
            'wht_invoice_amount' => "nullable|numeric",
            'vat_purchase_account' => "nullable|array",
            'wct_account' => "nullable|array",
            'revenue_account' => "nullable|array",
            'vat_sales_account' => "nullable|array",
            'customers_account' => "nullable|array",
            'wst_account' => "nullable|array",
            'cash_account' => "nullable|array",
            'card_account' => "nullable|array",
            'income_tax' => "nullable|numeric",
            'expenses_account' => "nullable|array",
            'wht_services' => "nullable|numeric",
            'cs_account' => "nullable|array",
            'fixed_assets_account' => "nullable|array",
            'dep_expenses_account' => "nullable|array",
            'funding_assets_account' => "nullable|array",
            'vendors_tax' => "nullable|numeric",
            'vendors_tax_account' => "nullable|array",
            'website_branch' => "nullable|numeric",
            'website_vat' => "nullable|string",
            'cash_accounts' => "nullable|array",
        ]);


        updateAccountSetting('assets_account', $request);
        updateAccountSetting('vendors_tax_account', $request);
        updateAccountSetting('funding_assets_account', $request);
        updateAccountSetting('dep_expenses_account', $request);
        updateAccountSetting('fixed_assets_account', $request);
        updateAccountSetting('cs_account', $request);
        updateAccountSetting('expenses_account', $request);
        updateAccountSetting('suppliers_account', $request);
        updateAccountSetting('cash_account', $request);
        updateAccountSetting('card_account', $request);
        updateAccountSetting('wst_account', $request);
        updateAccountSetting('customers_account', $request);
        updateAccountSetting('vat_sales_account', $request);
        updateAccountSetting('revenue_account', $request);
        updateAccountSetting('wct_account', $request);
        updateAccountSetting('vat_purchase_account', $request);
        updateAccountSetting('vat_purchase_account', $request);
        updateAccountSetting('cash_accounts', $request);



        updateSetting('website_branch', $request);
        updateSetting('website_vat', $request);
        updateSetting('wht_invoice_amount', $request);
        updateSetting('vat', $request);
        updateSetting('wht_products', $request);
        updateSetting('wht_services', $request);
        updateSetting('vendors_tax', $request);
        updateSetting('income_tax', $request);
        updateSetting('locale_pickup', $request);
        updateSetting('country_id', $request);
        updateSetting('shipping_method', $request);
        // updateSetting('warehouse_id', $request);
        updateSetting('max_price', $request);
        updateSetting('tax', $request);
        updateSetting('compression_ratio', $request);
        updateSetting('commission', $request);
        updateSetting('affiliate_limit', $request);
        updateSetting('vendor_limit', $request);
        updateSetting('mandatory_affiliate', $request);
        updateSetting('mandatory_vendor', $request);
        updateSetting('terms_ar', $request);
        updateSetting('terms_en', $request);
        updateSetting('front_modal', $request);
        updateSetting('affiliate_modal', $request);
        updateSetting('vendor_modal', $request);
        updateSetting('front_modal_title', $request);
        updateSetting('front_modal_body', $request);
        updateSetting('affiliate_modal_title', $request);
        updateSetting('affiliate_modal_body', $request);
        updateSetting('vendor_modal_title', $request);
        updateSetting('vendor_modal_body', $request);





        alertSuccess('Settings saved successfully', 'تم حفظ الإعدادات بنجاح');
        return redirect()->route('settings.index');
    }
}
