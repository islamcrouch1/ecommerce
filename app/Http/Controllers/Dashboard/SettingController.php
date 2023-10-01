<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Role;
use App\Models\Setting;
use App\Models\ShippingCompany;
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
        $countries = Country::all();
        $shipping_companies = ShippingCompany::all();
        $shipping_methods = ShippingMethod::all();
        $user = Auth::user();
        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }


        $taxes = array(
            'wht_invoice_amount',
            'vendors_tax',
            'income_tax',
            'wht_services',
            'wht_products',
            'vat'
        );

        foreach ($taxes as $tax) {
            setting($tax);
        }



        $default_accounts = array(
            'allowed_discount_account',
            'earned_discount_account',
            'assets_account',
            'vendors_tax_account',
            'funding_assets_account',
            'dep_expenses_account',
            'fixed_assets_account',
            'cs_account',
            'expenses_account',
            'suppliers_account',
            'cash_account',
            'card_account',
            'wst_account',
            'customers_account',
            'vat_sales_account',
            'revenue_account',
            'wct_account',
            'vat_purchase_account',
            'cash_accounts',
            'bank_accounts',
            'receipt_notes',
            'payment_notes',
            'employee_loan_account',
            'salaries_accounts',
            'staff_receivables_account',
            'social_insurance_account',
            'other_revenue_account',
            'petty_cash_account',
            'administrative_expense_account',
            'expenses_account_shipping',
            'revenue_account_shipping',
            'stock_interim_received_account',
            'stock_interim_delivered_account',
        );

        foreach ($shipping_companies as $company) {
            array_push($default_accounts, 'shipping_company_' . $company->id);
        }


        foreach ($branches as $branch) {
            foreach ($default_accounts as $index => $account) {
                settingAccount($account, $branch->id, $index);
            }
        }

        $assets_accounts = Account::where('account_type', 'assets')->where('reference_id', null)->get();
        $taxes = Tax::all();
        $liability_accounts = Account::where('account_type', 'liability')->where('reference_id', null)->get();
        $revenue_accounts = Account::where('account_type', 'revenue')->where('reference_id', null)->get();
        $expenses_accounts = Account::where('account_type', 'expenses')->where('reference_id', null)->get();
        $owners_equity_accounts = Account::where('account_type', 'owners_equity')->where('reference_id', null)->get();
        $roles = Role::WhereRoleNot(['superadministrator', 'administrator', 'user', 'vendor', 'affiliate'])->get();





        return view('dashboard.settings.index', compact('branches', 'owners_equity_accounts', 'roles', 'warehouses', 'countries', 'shipping_methods', 'assets_accounts', 'taxes', 'liability_accounts', 'revenue_accounts', 'expenses_accounts', 'shipping_companies'));
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
            'purchases_terms_ar' => "nullable|string",
            'purchases_terms_en' => "nullable|string",
            'sales_terms_ar' => "nullable|string",
            'sales_terms_en' => "nullable|string",
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
            'allowed_discount_account' => "nullable|array",
            'earned_discount_account' => "nullable|array",
            'website_branch' => "nullable|numeric",
            'website_vat' => "nullable|string",
            'cash_accounts' => "nullable|array",
            'cash_on_delivery' => "nullable|string",
            'paymob' => "nullable|string",
            'upayment' => "nullable|string",
            'paypal' => "nullable|string",
            'snapchat_pixel_id' => "nullable|string",
            'snapchat_token' => "nullable|string",
            'hotjar_id' => "nullable|string",
            'orders_email' => 'nullable|string|email',
            'google_analytics_id' => "nullable|string",
            'tiktok_id' => "nullable|string",
            'facebook_id' => "nullable|string",
            'facebook_token' => "nullable|string",
            'bank_accounts' => "nullable|array",
            'receipt_notes' => "nullable|array",
            'payment_notes' => "nullable|array",
            'tagmanager_id' => "nullable|string",
            'clients_notifications' => "nullable|array",
            'stock_notifications' => "nullable|array",
            'orders_notifications' => "nullable|array",
            'messages_notifications' => "nullable|array",
            'withdrawals_notifications' => "nullable|array",
            'allow_employees' => "nullable|string",


            'employee_loan_account' => "nullable|array",
            'salaries_accounts' => "nullable|array",
            'staff_receivables_account' => "nullable|array",
            'social_insurance_account' => "nullable|array",
            'other_revenue_account' => "nullable|array",
            'petty_cash_account' => "nullable|array",
            'administrative_expense_account' => "nullable|array",
            'expenses_account_shipping' => "nullable|array",
            'revenue_account_shipping' => "nullable|array",
            'stock_interim_received_account' => "nullable|array",
            'stock_interim_delivered_account' => "nullable|array",



            'serial_prefix_PO' => "nullable|string",
            'serial_prefix_SO' => "nullable|string",

            'serial_prefix_Q' => "nullable|string",
            'serial_prefix_RFQ' => "nullable|string",

            'serial_prefix_inv' => "nullable|string",
            'serial_prefix_bill' => "nullable|string",

            'serial_prefix_payment' => "nullable|string",
            'serial_prefix_receipt' => "nullable|string",


            'serial_prefix_credit_note' => "nullable|string",
            'serial_prefix_debit_note' => "nullable|string",






        ]);


        $shipping_companies = ShippingCompany::all();

        foreach ($shipping_companies as $company) {
            $request->validate([
                'shipping_company_' . $company->id => "nullable|array",
            ]);
        }


        updateAccountSetting('stock_interim_received_account', $request);
        updateAccountSetting('stock_interim_delivered_account', $request);


        updateAccountSetting('allowed_discount_account', $request);
        updateAccountSetting('earned_discount_account', $request);
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
        updateAccountSetting('cash_accounts', $request);
        updateAccountSetting('bank_accounts', $request);
        updateAccountSetting('receipt_notes', $request);
        updateAccountSetting('payment_notes', $request);


        updateAccountSetting('salaries_accounts', $request);
        updateAccountSetting('payment_notes', $request);
        updateAccountSetting('staff_receivables_account', $request);
        updateAccountSetting('social_insurance_account', $request);
        updateAccountSetting('other_revenue_account', $request);
        updateAccountSetting('petty_cash_account', $request);
        updateAccountSetting('administrative_expense_account', $request);
        updateAccountSetting('expenses_account_shipping', $request);
        updateAccountSetting('revenue_account_shipping', $request);








        foreach ($shipping_companies as $company) {
            updateAccountSetting('shipping_company_' . $company->id, $request);
        }



        updateSetting('clients_notifications', $request);
        updateSetting('stock_notifications', $request);
        updateSetting('orders_notifications', $request);
        updateSetting('messages_notifications', $request);
        updateSetting('withdrawals_notifications', $request);

        updateSetting('allow_employees', $request);


        updateSetting('serial_prefix_PO', $request);
        updateSetting('serial_prefix_SO', $request);
        updateSetting('serial_prefix_Q', $request);
        updateSetting('serial_prefix_RFQ', $request);
        updateSetting('serial_prefix_inv', $request);
        updateSetting('serial_prefix_bill', $request);
        updateSetting('serial_prefix_payment', $request);
        updateSetting('serial_prefix_receipt', $request);

        updateSetting('serial_prefix_credit_note', $request);
        updateSetting('serial_prefix_debit_note', $request);






        updateSetting('snapchat_pixel_id', $request);
        updateSetting('snapchat_token', $request);
        updateSetting('hotjar_id', $request);
        updateSetting('google_analytics_id', $request);
        updateSetting('tiktok_id', $request);
        updateSetting('facebook_id', $request);
        updateSetting('tagmanager_id', $request);
        updateSetting('facebook_token', $request);
        updateSetting('orders_email', $request);


        updateSetting('cash_on_delivery', $request);
        updateSetting('paymob', $request);
        updateSetting('upayment', $request);
        updateSetting('paypal', $request);


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
        updateSetting('purchases_terms_ar', $request);
        updateSetting('purchases_terms_en', $request);
        updateSetting('sales_terms_ar', $request);
        updateSetting('sales_terms_en', $request);

        updateSetting('front_modal', $request);
        updateSetting('affiliate_modal', $request);
        updateSetting('vendor_modal', $request);
        updateSetting('front_modal_title', $request);
        updateSetting('front_modal_body', $request);
        updateSetting('affiliate_modal_title', $request);
        updateSetting('affiliate_modal_body', $request);
        updateSetting('vendor_modal_title', $request);
        updateSetting('vendor_modal_body', $request);

        updateSetting('product_review', $request);
        updateSetting('order_review', $request);




        alertSuccess('Settings saved successfully', 'تم حفظ الإعدادات بنجاح');
        return redirect()->route('settings.index');
    }
}
