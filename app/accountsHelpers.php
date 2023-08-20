<?php



use App\Models\Account;
use App\Models\Entry;
use App\Models\Setting;
use App\Models\ShippingCompany;
use Illuminate\Support\Facades\Auth;


// check accounts settings
if (!function_exists('checkAccounts')) {
    function checkAccounts($branch_id, $types)
    {
        $check = true;
        foreach ($types as $type) {
            if (!settingAccount($type, $branch_id)) {
                $check = false;
            }
        }
        return $check;
    }
}

// check order accounts
if (!function_exists('checkOrderAccounts')) {
    function checkOrderAccounts($order_from, $branch_id)
    {
        $check = true;
        if ($order_from == 'addpurchase') {

            if (!checkAccounts($branch_id, ['suppliers_account', 'vat_purchase_account', 'wct_account', 'revenue_account', 'earned_discount_account'])) {
                $check = false;
            }
        } elseif ($order_from == 'addsale') {
            if (!checkAccounts($branch_id, ['vat_sales_account', 'wst_account', 'customers_account', 'revenue_account', 'allowed_discount_account'])) {
                $check = false;
            }
        } elseif ($order_from == 'web') {
            if (!checkAccounts($branch_id, ['vendors_tax_account', 'wst_account', 'customers_account', 'revenue_account', 'allowed_discount_account']) || setting('vat') == null || setting('vendors_tax') == null || setting('website_branch') == null) {
                $check = false;
            }
        }
        return $check;
    }
}


// check order accounts
if (!function_exists('getEntryDetailsCr')) {
    function getEntryDetailsCr($entry)
    {
        $entries = Entry::where('description', $entry->description)->where('dr_amount', 0)
            ->get();

        return $entries;
    }
}


// check order accounts
if (!function_exists('getEntryDetailsDr')) {
    function getEntryDetailsDr($entry)
    {
        $entries = Entry::where('description', $entry->description)->where('cr_amount', 0)
            ->get();

        return $entries;
    }
}





// get account id from setting and create it if not exist
if (!function_exists('settingAccount')) {
    function settingAccount($type, $branch_id)
    {
        $setting = Setting::where('type', $type)->where('reference_type', 'accounts')->where('reference_id', $branch_id)->first();
        $account_id = null;

        if ($setting == null) {

            $last_account = Account::where('parent_id', null)->orderBy('created_at', 'desc')->first();

            if ($last_account == null) {
                $code = '100';
            } else {
                $code = $last_account->code + rand(10, 100);
            }

            // if ($index == 4) {
            //     dd($last_account, $code);
            // }

            $account_name = getAccountNameForSetting($type);
            $account_type = getAccountTypeForSetting($type);

            $account = Account::create([
                'name_ar' => $account_name['ar'],
                'name_en' => $account_name['en'],
                'code' => $code,
                'parent_id' => null,
                'account_type' => $account_type,
                'branch_id' => $branch_id,
                'created_by' => Auth::id(),
            ]);

            Setting::create([
                'type' => $type,
                'value' => $account->id,
                'reference_type' => 'accounts',
                'reference_id' => $branch_id
            ]);

            $account_id = $account->id;
        }

        return $setting ? $setting->value : $account_id;
    }
}


// get account name for main account in settings in arabic and english
if (!function_exists('getAccountNameForSetting')) {
    function getAccountNameForSetting($type)
    {

        $name = [];


        if (strstr($type, 'shipping_company_')) {
            $id = substr($type, 17);
            $company = ShippingCompany::findOrFail($id);
            $name['en'] = 'Intermediary Account for shipping company' . ' - ' . $company->name_en;
            $name['ar'] = 'حساب وسيط لشركة الشحن' . ' - ' . $company->name_ar;
        } else {
            switch ($type) {
                case 'allowed_discount_account':
                    $name['en'] = 'Allowed Discount Account';
                    $name['ar'] = 'حساب الخصم المسموح به';
                    break;
                case 'earned_discount_account':
                    $name['en'] = 'Earned Discount Account';
                    $name['ar'] = 'حساب الخصم المكتسب';
                    break;
                case 'assets_account':
                    $name['en'] = 'Assets Account';
                    $name['ar'] = 'حساب الأصول';
                    break;
                case 'vendors_tax_account':
                    $name['en'] = 'Vendors Tax Account';
                    $name['ar'] = 'حساب ضريبة الموردين';
                    break;
                case 'funding_assets_account':
                    $name['en'] = 'Assets Funding Account';
                    $name['ar'] = 'حساب تمويل الاصول';
                    break;
                case 'dep_expenses_account':
                    $name['en'] = 'Depreciation Expenses Account';
                    $name['ar'] = 'حساب مصاريف الإهلاك';
                    break;
                case 'fixed_assets_account':
                    $name['en'] = 'Fixed Assets Account';
                    $name['ar'] = 'حساب الأصول الثابتة';
                    break;
                case 'cs_account':
                    $name['en'] = 'Cost of Goods Sold Account';
                    $name['ar'] = 'حساب تكلفة البضاعة المباعة';
                    break;
                case 'expenses_account':
                    $name['en'] = 'Expenses Account';
                    $name['ar'] = 'حساب المصاريف';
                    break;
                case 'suppliers_account':
                    $name['en'] = 'Suppliers Account';
                    $name['ar'] = 'حساب الموردين';
                    break;
                case 'cash_account':
                    $name['en'] = 'Intermediary Account for Cash on Delivery Payment Method';
                    $name['ar'] = 'حساب وسيط لطريقة الدفع عند الاستلام';
                    break;
                case 'card_account':
                    $name['en'] = 'Intermediary Account for Cards Payment Method';
                    $name['ar'] = 'حساب وسيط لطريقة الدفع بالبطاقات';
                    break;
                case 'wst_account':
                    $name['en'] = 'Withholding at Source Tax Account for Sales';
                    $name['ar'] = 'حساب ضريبة الخصم من المنبع للمبيعات';
                    break;
                case 'customers_account':
                    $name['en'] = 'Customers Account';
                    $name['ar'] = 'حساب العملاء';
                    break;
                case 'vat_sales_account':
                    $name['en'] = 'VAT on Sales Account';
                    $name['ar'] = 'حساب ضريبة القيمة المضافة على المبيعات';
                    break;
                case 'revenue_account':
                    $name['en'] = 'Revenue Account';
                    $name['ar'] = 'حساب الإيرادات';
                    break;
                case 'wct_account':
                    $name['en'] = 'Withholding and Collection Tax Account for Purchases';
                    $name['ar'] = 'حساب ضريبة الخصم والتحصيل للمشتريات';
                    break;
                case 'vat_purchase_account':
                    $name['en'] = 'VAT on Purchases Account';
                    $name['ar'] = 'حساب ضريبة القيمة المضافة على المشتريات';
                    break;
                case 'cash_accounts':
                    $name['en'] = 'Cash Account';
                    $name['ar'] = 'الخزينة نقدي';
                    break;
                case 'bank_accounts':
                    $name['en'] = 'Banks Account';
                    $name['ar'] = 'حساب البنوك';
                    break;
                case 'receipt_notes':
                    $name['en'] = 'Receipt Notes Account';
                    $name['ar'] = 'حساب اوراق القبض';
                    break;
                case 'payment_notes':
                    $name['en'] = 'Payment Notes Account';
                    $name['ar'] = 'حساب اوراق الدفع';
                    break;
                case 'employee_loan_account':
                    $name['en'] = 'Employee loan account';
                    $name['ar'] = 'حساب قروض الموظفين';
                    break;
                case 'salaries_accounts':
                    $name['en'] = 'Salaries and Wages Accountt';
                    $name['ar'] = 'حساب الرواتب والاجور';
                    break;
                case 'staff_receivables_account':
                    $name['en'] = 'Staff Receivables account';
                    $name['ar'] = 'حساب ذمم الموظفين';
                    break;
                case 'social_insurance_account':
                    $name['en'] = 'Social insurance account';
                    $name['ar'] = 'حساب التامينات الاجتماعية';
                    break;
                case 'other_revenue_account':
                    $name['en'] = 'Other revenue account';
                    $name['ar'] = 'حساب الايرادات المتنوعة';
                    break;
                case 'petty_cash_account':
                    $name['en'] = 'Petty cash account';
                    $name['ar'] = 'حساب العهد';
                    break;
                case 'administrative_expense_account':
                    $name['en'] = 'Administrative expense account';
                    $name['ar'] = 'حساب المصاريف الادارية';
                    break;
                case 'expenses_account_shipping':
                    $name['en'] = 'expense account for shipping';
                    $name['ar'] = 'حساب المصاريف للشحن';
                    break;
                case 'revenue_account_shipping':
                    $name['en'] = 'revenue account for shipping';
                    $name['ar'] = 'حساب ايرادات الشحن';
                    break;




                default:
                    $name['en'] = '';
                    $name['ar'] = '';
                    break;
            }
        }



        return $name;
    }
}


// get account type according to accountant accounts type
if (!function_exists('getAccountTypeForSetting')) {
    function getAccountTypeForSetting($type)
    {


        if (strstr($type, 'shipping_company_')) {
            $account_type = 'assets';
        } else {

            switch ($type) {
                case 'allowed_discount_account':
                    $account_type = 'expenses';
                    break;
                case 'earned_discount_account':
                    $account_type = 'revenue';
                    break;
                case 'assets_account':
                    $account_type = 'assets';
                    break;
                case 'vendors_tax_account':
                    $account_type = 'liability';
                    break;
                case 'funding_assets_account':
                    $account_type = 'assets';
                    break;
                case 'dep_expenses_account':
                    $account_type = 'expenses';
                    break;
                case 'fixed_assets_account':
                    $account_type = 'assets';
                    break;
                case 'cs_account':
                    $account_type = 'liability';
                    break;
                case 'expenses_account':
                    $account_type = 'expenses';
                    break;
                case 'suppliers_account':
                    $account_type = 'liability';
                    break;
                case 'cash_account':
                    $account_type = 'assets';
                    break;
                case 'card_account':
                    $account_type = 'assets';
                    break;
                case 'wst_account':
                    $account_type = 'assets';
                    break;
                case 'customers_account':
                    $account_type = 'assets';
                    break;
                case 'vat_sales_account':
                    $account_type = 'liability';
                    break;
                case 'revenue_account':
                    $account_type = 'revenue';
                    break;
                case 'wct_account':
                    $account_type = 'liability';
                    break;
                case 'vat_purchase_account':
                    $account_type = 'assets';
                    break;
                case 'cash_accounts':
                    $account_type = 'assets';
                    break;
                case 'bank_accounts':
                    $account_type = 'assets';
                    break;
                case 'receipt_notes':
                    $account_type = 'assets';
                    break;
                case 'payment_notes':
                    $account_type = 'liability';
                    break;
                case 'employee_loan_account':
                    $account_type = 'assets';
                    break;
                case 'salaries_accounts':
                    $account_type = 'expenses';
                    break;
                case 'staff_receivables_account':
                    $account_type = 'liability';
                    break;
                case 'social_insurance_account':
                    $account_type = 'liability';
                    break;
                case 'other_revenue_account':
                    $account_type = 'revenue';
                    break;
                case 'petty_cash_account':
                    $account_type = 'assets';
                    break;
                case 'administrative_expense_account':
                    $account_type = 'expenses';
                    break;
                case 'expenses_account_shipping':
                    $account_type = 'expenses';
                    break;
                case 'revenue_account_shipping':
                    $account_type = 'revenue';
                    break;


                default:
                    $account_type = '';
                    break;
            }
        }

        return $account_type;
    }
}



if (!function_exists('getIntermediaryAssetAccount')) {
    function getIntermediaryAssetAccount($order, $branch_id)
    {
        if ($order->payment_method == 'cash_on_delivery') {

            $state = $order->state;
            if ($state->shipping_company_id == null) {
                $cash_account = Account::findOrFail(settingAccount('cash_account', $branch_id));
            } else {
                $company = ShippingCompany::find($state->shipping_company_id);
                if ($company) {
                    $cash_account = Account::findOrFail(settingAccount('shipping_company_' . $company->id, $branch_id));
                } else {
                    $cash_account = Account::findOrFail(settingAccount('cash_account', $branch_id));
                }
            }
        } elseif ($order->payment_method == 'paymob' || $order->payment_method == 'upayment' || $order->payment_method == 'paypal') {
            $cash_account = Account::findOrFail(settingAccount('card_account', $branch_id));
        }

        return $cash_account;
    }
}
