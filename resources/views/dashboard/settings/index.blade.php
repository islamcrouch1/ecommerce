@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Settings') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">

                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                            @csrf


                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="taxes-tab" data-bs-toggle="tab"
                                        href="#tab-taxes" role="tab" aria-controls="tab-taxes"
                                        aria-selected="true">{{ __('taxes') }}</a></li>

                                @foreach ($branches as $branch)
                                    <li class="nav-item"><a class="nav-link " id="accounts-tab-{{ $branch->id }}"
                                            data-bs-toggle="tab" href="#tab-accounts-{{ $branch->id }}" role="tab"
                                            aria-controls="tab-accounts"
                                            aria-selected="true">{{ __('accounts') . ' - ' . getName($branch) }}</a></li>
                                @endforeach




                                <li class="nav-item"><a class="nav-link " id="shipping-tab" data-bs-toggle="tab"
                                        href="#tab-shipping" role="tab" aria-controls="tab-shipping"
                                        aria-selected="true">{{ __('shipping') }}</a></li>
                                <li class="nav-item"><a class="nav-link " id="terms-tab" data-bs-toggle="tab"
                                        href="#tab-terms" role="tab" aria-controls="tab-terms"
                                        aria-selected="true">{{ __('terms') }}</a></li>
                                <li class="nav-item"><a class="nav-link " id="purchases-tab" data-bs-toggle="tab"
                                        href="#tab-purchases" role="tab" aria-controls="tab-purchases"
                                        aria-selected="true">{{ __('purchases') }}</a></li>
                                <li class="nav-item"><a class="nav-link " id="sales-tab" data-bs-toggle="tab"
                                        href="#tab-sales" role="tab" aria-controls="tab-sales"
                                        aria-selected="true">{{ __('sales') }}</a></li>
                                <li class="nav-item"><a class="nav-link " id="general-tab" data-bs-toggle="tab"
                                        href="#tab-general" role="tab" aria-controls="tab-general"
                                        aria-selected="true">{{ __('general settings') }}</a></li>
                                <li class="nav-item"><a class="nav-link " id="affiliate-tab" data-bs-toggle="tab"
                                        href="#tab-affiliate" role="tab" aria-controls="tab-affiliate"
                                        aria-selected="true">{{ __('affiliate') }}</a></li>
                                <li class="nav-item"><a class="nav-link " id="payment-tab" data-bs-toggle="tab"
                                        href="#tab-payment" role="tab" aria-controls="tab-payment"
                                        aria-selected="true">{{ __('payment methods') }}</a></li>
                                <li class="nav-item"><a class="nav-link " id="social-tab" data-bs-toggle="tab"
                                        href="#tab-social" role="tab" aria-controls="tab-social"
                                        aria-selected="true">{{ __('social media api') }}</a></li>

                                <li class="nav-item"><a class="nav-link " id="notifications-tab" data-bs-toggle="tab"
                                        href="#tab-notifications" role="tab" aria-controls="tab-notifications"
                                        aria-selected="true">{{ __('notifications') }}</a></li>

                            </ul>

                            <div class="tab-content border-x border-bottom p-3" id="myTabContent">



                                <div class="tab-pane fade show active" id="tab-taxes" role="tabpanel"
                                    aria-labelledby="taxes-tab">



                                    <div class="mb-3">
                                        <label class="form-label" for="vat">{{ __('default added tax') }}</label>

                                        <select class="form-select @error('vat') is-invalid @enderror" aria-label=""
                                            name="vat" id="vat">
                                            <option value="">{{ __('select tax') }}</option>

                                            @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}"
                                                    {{ setting('vat') == $tax->id ? 'selected' : '' }}>
                                                    {{ $tax->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('vat')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="wht_products">{{ __('default withholding tax for products') }}</label>

                                        <select class="form-select @error('wht_products') is-invalid @enderror"
                                            aria-label="" name="wht_products" id="wht_products">
                                            <option value="">{{ __('select tax') }}</option>

                                            @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}"
                                                    {{ setting('wht_products') == $tax->id ? 'selected' : '' }}>
                                                    {{ $tax->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('wht_products')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="wht_services">{{ __('default withholding tax for services') }}</label>

                                        <select class="form-select @error('wht_services') is-invalid @enderror"
                                            aria-label="" name="wht_services" id="wht_services">
                                            <option value="">{{ __('select tax') }}</option>

                                            @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}"
                                                    {{ setting('wht_services') == $tax->id ? 'selected' : '' }}>
                                                    {{ $tax->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('wht_services')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="income_tax">{{ __('default income tax') }}</label>

                                        <select class="form-select @error('income_tax') is-invalid @enderror"
                                            aria-label="" name="income_tax" id="income_tax">
                                            <option value="">{{ __('select tax') }}</option>

                                            @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}"
                                                    {{ setting('income_tax') == $tax->id ? 'selected' : '' }}>
                                                    {{ $tax->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('income_tax')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="vendors_tax">{{ __('default tax for vendors products commissions') }}</label>

                                        <select class="form-select @error('vendors_tax') is-invalid @enderror"
                                            aria-label="" name="vendors_tax" id="income_tax">
                                            <option value="">{{ __('select tax') }}</option>

                                            @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}"
                                                    {{ setting('vendors_tax') == $tax->id ? 'selected' : '' }}>
                                                    {{ $tax->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('vendors_tax')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="wht_invoice_amount">{{ __('total invoice amount to apply withholding tax') }}</label>
                                        <input name="wht_invoice_amount"
                                            class="form-control @error('wht_invoice_amount') is-invalid @enderror"
                                            value="{{ setting('wht_invoice_amount') }}" type="number" autocomplete="on"
                                            id="wht_invoice_amount" autofocus />
                                        @error('wht_invoice_amount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="website_vat">{{ __('Applying value added tax to website sales') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="website_vat"
                                                    class="form-control @error('website_vat') is-invalid @enderror"
                                                    name="website_vat" type="checkbox"
                                                    {{ setting('website_vat') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('website_vat')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                @foreach ($branches as $branch)
                                    <div class="tab-pane fade show " id="tab-accounts-{{ $branch->id }}"
                                        role="tabpanel" aria-labelledby="accounts-tab-{{ $branch->id }}">


                                        {!! getDivForAccountsSetting(
                                            'assets_account',
                                            'default current assets account for inventory',
                                            $assets_accounts,
                                            $branch->id,
                                        ) !!}



                                        {!! getDivForAccountsSetting(
                                            'cs_account',
                                            'default expenses account for cost of goods sold',
                                            $expenses_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'funding_assets_account',
                                            'default funding assets account',
                                            $owners_equity_accounts,
                                            $branch->id,
                                        ) !!}



                                        {!! getDivForAccountsSetting(
                                            'fixed_assets_account',
                                            'default non current assets account',
                                            $assets_accounts,
                                            $branch->id,
                                        ) !!}



                                        {!! getDivForAccountsSetting(
                                            'dep_expenses_account',
                                            'default depreciation expenses account',
                                            $expenses_accounts,
                                            $branch->id,
                                        ) !!}





                                        {!! getDivForAccountsSetting(
                                            'cash_account',
                                            'default assets account for cash on delivery payment method',
                                            $assets_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'card_account',
                                            'default assets account for card payment method',
                                            $assets_accounts,
                                            $branch->id,
                                        ) !!}


                                        @foreach ($shipping_companies as $company)
                                            {!! getDivForAccountsSetting(
                                                'shipping_company_' . $company->id,
                                                'default assets account for shipping company',
                                                $assets_accounts,
                                                $branch->id,
                                                null,
                                                $company,
                                            ) !!}
                                        @endforeach


                                        {!! getDivForAccountsSetting(
                                            'revenue_account',
                                            'default revenue account for sales',
                                            $revenue_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'customers_account',
                                            'default assets account for customers',
                                            $assets_accounts,
                                            $branch->id,
                                        ) !!}






                                        {!! getDivForAccountsSetting(
                                            'suppliers_account',
                                            'default liability account for suppliers',
                                            $liability_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'vat_purchase_account',
                                            'default added value tax account for purchases',
                                            $assets_accounts,
                                            $branch->id,
                                        ) !!}



                                        {!! getDivForAccountsSetting(
                                            'vat_sales_account',
                                            'default added value tax account for sales',
                                            $liability_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'vendors_tax_account',
                                            'default commission tax account for vendors products',
                                            $liability_accounts,
                                            $branch->id,
                                        ) !!}



                                        {!! getDivForAccountsSetting(
                                            'wct_account',
                                            'default withholding and collection tax account for purchases',
                                            $liability_accounts,
                                            $branch->id,
                                        ) !!}



                                        {!! getDivForAccountsSetting(
                                            'wst_account',
                                            'default withholding at source tax account for sales',
                                            $assets_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting('cash_accounts', 'default cash treasury account', $assets_accounts, $branch->id) !!}
                                        {!! getDivForAccountsSetting('bank_accounts', 'default banks account', $assets_accounts, $branch->id) !!}
                                        {!! getDivForAccountsSetting('receipt_notes', 'default receipt notes account', $assets_accounts, $branch->id) !!}
                                        {!! getDivForAccountsSetting('payment_notes', 'default payment notes account', $liability_accounts, $branch->id) !!}


                                        {!! getDivForAccountsSetting('expenses_account', 'default expenses account', $expenses_accounts, $branch->id) !!}


                                        {!! getDivForAccountsSetting(
                                            'allowed_discount_account',
                                            'default allowed discount account',
                                            $expenses_accounts,
                                            $branch->id,
                                        ) !!}

                                        {!! getDivForAccountsSetting(
                                            'earned_discount_account',
                                            'default earned discount account',
                                            $revenue_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'employee_loan_account',
                                            'default employee loan account',
                                            $assets_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'salaries_accounts',
                                            'default salaries and wages account',
                                            $expenses_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'staff_receivables_account',
                                            'default staff receivables account',
                                            $liability_accounts,
                                            $branch->id,
                                        ) !!}



                                        {!! getDivForAccountsSetting(
                                            'social_insurance_account',
                                            'default social insurance account',
                                            $liability_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'other_revenue_account',
                                            'default other revenue account',
                                            $revenue_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting('petty_cash_account', 'default petty cash account', $assets_accounts, $branch->id) !!}



                                        {!! getDivForAccountsSetting(
                                            'administrative_expense_account',
                                            'default administrative expense account',
                                            $expenses_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'expenses_account_shipping',
                                            'default expense account for shipping',
                                            $expenses_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'revenue_account_shipping',
                                            'default revenue account for shipping',
                                            $revenue_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'stock_interim_received_account',
                                            'stock interim received account',
                                            $assets_accounts,
                                            $branch->id,
                                        ) !!}

                                        {!! getDivForAccountsSetting(
                                            'stock_interim_delivered_account',
                                            'stock interim delivered account',
                                            $assets_accounts,
                                            $branch->id,
                                        ) !!}

                                    </div>
                                @endforeach


                                <div class="tab-pane fade show " id="tab-shipping" role="tabpanel"
                                    aria-labelledby="shipping-tab">

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="shipping_method">{{ __('default shipping method') }}</label>

                                        <select class="form-select @error('shipping_method') is-invalid @enderror"
                                            aria-label="" name="shipping_method" id="shipping_method">
                                            <option value="">
                                                {{ __('select shipping method') }}
                                            </option>
                                            @foreach ($shipping_methods as $method)
                                                <option value="{{ $method->id }}"
                                                    {{ setting('shipping_method') == $method->id ? 'selected' : '' }}>
                                                    {{ app()->getLocale() == 'ar' ? $method->name_ar : $method->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('shipping_method')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="locale_pickup">{{ __('localPickup activate') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="locale_pickup"
                                                    class="form-control @error('locale_pickup') is-invalid @enderror"
                                                    name="locale_pickup" type="checkbox"
                                                    {{ setting('locale_pickup') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('locale_pickup')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

                                <div class="tab-pane fade show " id="tab-terms" role="tabpanel"
                                    aria-labelledby="terms-tab">


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="terms_ar">{{ __('Terms and conditions - arabic') }}</label>
                                        <textarea name="terms_ar" class="form-control tinymce @error('terms_ar') is-invalid @enderror" autocomplete="on"
                                            id="terms_ar">{!! setting('terms_ar') !!}</textarea>
                                        @error('terms_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="terms_en">{{ __('Terms and conditions - english') }}</label>
                                        <textarea name="terms_en" class="form-control tinymce @error('terms_en') is-invalid @enderror" autocomplete="on"
                                            id="terms_en">{!! setting('terms_en') !!}</textarea>
                                        @error('terms_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>

                                <div class="tab-pane fade show " id="tab-purchases" role="tabpanel"
                                    aria-labelledby="purchases-tab">





                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="serial_prefix_PO">{{ __('serial prefix for PO') }}</label>
                                        <input name="serial_prefix_PO"
                                            class="form-control @error('serial_prefix_PO') is-invalid @enderror"
                                            value="{{ setting('serial_prefix_PO') }}" type="text" autocomplete="on"
                                            id="serial_prefix_PO" autofocus />
                                        @error('serial_prefix_PO')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="serial_prefix_RFQ">{{ __('serial prefix for RFQ') }}</label>
                                        <input name="serial_prefix_RFQ"
                                            class="form-control @error('serial_prefix_RFQ') is-invalid @enderror"
                                            value="{{ setting('serial_prefix_RFQ') }}" type="text" autocomplete="on"
                                            id="serial_prefix_RFQ" autofocus />
                                        @error('serial_prefix_RFQ')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="serial_prefix_bill">{{ __('serial prefix for bills') }}</label>
                                        <input name="serial_prefix_bill"
                                            class="form-control @error('serial_prefix_bill') is-invalid @enderror"
                                            value="{{ setting('serial_prefix_bill') }}" type="text" autocomplete="on"
                                            id="serial_prefix_bill" autofocus />
                                        @error('serial_prefix_bill')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="serial_prefix_debit_note">{{ __('serial prefix for debit notes') }}</label>
                                        <input name="serial_prefix_debit_note"
                                            class="form-control @error('serial_prefix_debit_note') is-invalid @enderror"
                                            value="{{ setting('serial_prefix_debit_note') }}" type="text"
                                            autocomplete="on" id="serial_prefix_debit_note" autofocus />
                                        @error('serial_prefix_debit_note')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="serial_prefix_payment">{{ __('serial prefix for payments') }}</label>
                                        <input name="serial_prefix_payment"
                                            class="form-control @error('serial_prefix_payment') is-invalid @enderror"
                                            value="{{ setting('serial_prefix_payment') }}" type="text"
                                            autocomplete="on" id="serial_prefix_payment" autofocus />
                                        @error('serial_prefix_payment')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>




                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="purchases_terms_ar">{{ __('Terms and conditions - arabic') }}</label>
                                        <textarea name="purchases_terms_ar" class="form-control tinymce @error('purchases_terms_ar') is-invalid @enderror"
                                            autocomplete="on" id="purchases_terms_ar">{!! setting('purchases_terms_ar') !!}</textarea>
                                        @error('purchases_terms_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="purchases_terms_en">{{ __('Terms and conditions - english') }}</label>
                                        <textarea name="purchases_terms_en" class="form-control tinymce @error('purchases_terms_en') is-invalid @enderror"
                                            autocomplete="on" id="purchases_terms_en">{!! setting('purchases_terms_en') !!}</textarea>
                                        @error('purchases_terms_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>

                                <div class="tab-pane fade show " id="tab-sales" role="tabpanel"
                                    aria-labelledby="sales-tab">



                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="serial_prefix_SO">{{ __('serial prefix for SO') }}</label>
                                        <input name="serial_prefix_SO"
                                            class="form-control @error('serial_prefix_SO') is-invalid @enderror"
                                            value="{{ setting('serial_prefix_SO') }}" type="text" autocomplete="on"
                                            id="serial_prefix_SO" autofocus />
                                        @error('serial_prefix_SO')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="serial_prefix_Q">{{ __('serial prefix for Q') }}</label>
                                        <input name="serial_prefix_Q"
                                            class="form-control @error('serial_prefix_Q') is-invalid @enderror"
                                            value="{{ setting('serial_prefix_Q') }}" type="text" autocomplete="on"
                                            id="serial_prefix_Q" autofocus />
                                        @error('serial_prefix_Q')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="serial_prefix_inv">{{ __('serial prefix for invoices') }}</label>
                                        <input name="serial_prefix_inv"
                                            class="form-control @error('serial_prefix_inv') is-invalid @enderror"
                                            value="{{ setting('serial_prefix_inv') }}" type="text" autocomplete="on"
                                            id="serial_prefix_inv" autofocus />
                                        @error('serial_prefix_inv')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="serial_prefix_credit_note">{{ __('serial prefix for credit notes') }}</label>
                                        <input name="serial_prefix_credit_note"
                                            class="form-control @error('serial_prefix_credit_note') is-invalid @enderror"
                                            value="{{ setting('serial_prefix_credit_note') }}" type="text"
                                            autocomplete="on" id="serial_prefix_credit_note" autofocus />
                                        @error('serial_prefix_credit_note')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="serial_prefix_receipt">{{ __('serial prefix for receipts') }}</label>
                                        <input name="serial_prefix_receipt"
                                            class="form-control @error('serial_prefix_receipt') is-invalid @enderror"
                                            value="{{ setting('serial_prefix_receipt') }}" type="text"
                                            autocomplete="on" id="serial_prefix_receipt" autofocus />
                                        @error('serial_prefix_receipt')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="sales_terms_ar">{{ __('Terms and conditions - arabic') }}</label>
                                        <textarea name="sales_terms_ar" class="form-control tinymce @error('sales_terms_ar') is-invalid @enderror"
                                            autocomplete="on" id="sales_terms_ar">{!! setting('sales_terms_ar') !!}</textarea>
                                        @error('sales_terms_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="sales_terms_en">{{ __('Terms and conditions - english') }}</label>
                                        <textarea name="sales_terms_en" class="form-control tinymce @error('sales_terms_en') is-invalid @enderror"
                                            autocomplete="on" id="sales_terms_en">{!! setting('sales_terms_en') !!}</textarea>
                                        @error('sales_terms_en')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>

                                <div class="tab-pane fade show " id="tab-general" role="tabpanel"
                                    aria-labelledby="general-tab">


                                    <div class="mb-3">
                                        <label class="form-label" for="country_id">{{ __('default country') }}</label>

                                        <select class="form-select @error('country_id') is-invalid @enderror"
                                            aria-label="" name="country_id" id="country_id">
                                            <option value="">
                                                {{ __('select country') }}
                                            </option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ setting('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="default_lang">{{ __('default language') }}</label>

                                        <select class="form-select @error('default_lang') is-invalid @enderror"
                                            aria-label="" name="default_lang" id="default_lang">
                                            <option value="">
                                                {{ __('select language') }}
                                            </option>
                                            <option value="ar"
                                                {{ setting('default_lang') == 'ar' ? 'selected' : '' }}>
                                                {{ __('arabic') }}
                                            </option>
                                            <option value="en"
                                                {{ setting('default_lang') == 'en' ? 'selected' : '' }}>
                                                {{ __('english') }}
                                            </option>
                                        </select>
                                        @error('default_lang')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="main_route">{{ __('main link redirection') }}</label>

                                        <select class="form-select @error('main_route') is-invalid @enderror"
                                            aria-label="" name="main_route" id="main_route">
                                            <option value="admin_login"
                                                {{ setting('main_route') == 'admin_login' ? 'selected' : '' }}>
                                                {{ __('admin login') }}
                                            </option>
                                            <option value="ecommerce_home"
                                                {{ setting('main_route') == 'ecommerce_home' ? 'selected' : '' }}>
                                                {{ __('ecommerce home') }}
                                            </option>
                                            <option value="presentation_website"
                                                {{ setting('main_route') == 'presentation_website' ? 'selected' : '' }}>
                                                {{ __('presentation website') }}
                                            </option>
                                        </select>
                                        @error('default_lang')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="compression_ratio">{{ __('Image Compression Ratio') }}</label>
                                        <input name="compression_ratio"
                                            class="form-control @error('compression_ratio') is-invalid @enderror"
                                            value="{{ setting('compression_ratio') }}" type="number" autocomplete="on"
                                            id="compression_ratio" />
                                        @error('compression_ratio')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">

                                        <label class="form-label"
                                            for="website_branch">{{ __('Website default branch') }}</label>
                                        <select class="form-select @error('website_branch') is-invalid @enderror"
                                            aria-label="" name="website_branch" id="website_branch">
                                            <option value="">
                                                {{ __('select branch') }}
                                            </option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ setting('website_branch') == $branch->id ? 'selected' : '' }}>
                                                    {{ getName($branch) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('website_branch')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="orders_email">{{ __('email to receive orders') }}</label>
                                        <input name="orders_email"
                                            class="form-control @error('orders_email') is-invalid @enderror"
                                            value="{{ setting('orders_email') }}" type="text" autocomplete="on"
                                            id="orders_email" />
                                        @error('orders_email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="product_review">{{ __('enable review in product page') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="product_review"
                                                    class="form-control @error('product_review') is-invalid @enderror"
                                                    name="product_review" type="checkbox"
                                                    {{ setting('product_review') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('product_review')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="order_review">{{ __('enable review after success order') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="order_review"
                                                    class="form-control @error('order_review') is-invalid @enderror"
                                                    name="order_review" type="checkbox"
                                                    {{ setting('order_review') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('order_review')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="allow_employees">{{ __('Time to allow employees to attend') . ' ' . __('in minutes') }}</label>
                                        <input name="allow_employees"
                                            class="form-control @error('allow_employees') is-invalid @enderror"
                                            value="{{ setting('allow_employees') }}" type="number" autocomplete="on"
                                            id="allow_employees" />
                                        @error('allow_employees')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>




                                </div>

                                <div class="tab-pane fade show " id="tab-affiliate" role="tabpanel"
                                    aria-labelledby="affiliate-tab">


                                    <div class="mb-3">
                                        <label class="form-label" for="tax">{{ __('Tax %') }}</label>
                                        <input name="tax" class="form-control @error('tax') is-invalid @enderror"
                                            value="{{ setting('tax') }}" type="number" autocomplete="on"
                                            id="tax" autofocus />
                                        @error('tax')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="max_price">{{ __('Max Price %') }}</label>
                                        <input name="max_price"
                                            class="form-control @error('max_price') is-invalid @enderror"
                                            value="{{ setting('max_price') }}" type="number" autocomplete="on"
                                            id="max_price" />
                                        @error('max_price')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="commission">{{ __('Suggested commission %') }}</label>
                                        <input name="commission"
                                            class="form-control @error('commission') is-invalid @enderror"
                                            value="{{ setting('commission') }}" type="number" autocomplete="on"
                                            id="commission" />
                                        @error('commission')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="affiliate_limit">{{ __('Affiliate withdrawal limit') }}</label>
                                        <input name="affiliate_limit"
                                            class="form-control @error('affiliate_limit') is-invalid @enderror"
                                            value="{{ setting('affiliate_limit') }}" type="number" autocomplete="on"
                                            id="affiliate_limit" />
                                        @error('affiliate_limit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="vendor_limit">{{ __('Vendor withdrawal limit') }}</label>
                                        <input name="vendor_limit"
                                            class="form-control @error('vendor_limit') is-invalid @enderror"
                                            value="{{ setting('vendor_limit') }}" type="number" autocomplete="on"
                                            id="vendor_limit" />
                                        @error('vendor_limit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="mandatory_affiliate">{{ __('Mandatory Period For Affiliate') . __(' - in minutes') }}</label>
                                        <input name="mandatory_affiliate"
                                            class="form-control @error('mandatory_affiliate') is-invalid @enderror"
                                            value="{{ setting('mandatory_affiliate') }}" type="number"
                                            autocomplete="on" id="mandatory_affiliate" />
                                        @error('mandatory_affiliate')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="mandatory_vendor">{{ __('Mandatory Period For Vendors') . __(' - in minutes') }}</label>
                                        <input name="mandatory_vendor"
                                            class="form-control @error('mandatory_vendor') is-invalid @enderror"
                                            value="{{ setting('mandatory_vendor') }}" type="number" autocomplete="on"
                                            id="mandatory_vendor" />
                                        @error('mandatory_vendor')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>

                                <div class="tab-pane fade show " id="tab-payment" role="tabpanel"
                                    aria-labelledby="general-tab">



                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="cash_on_delivery">{{ __('cash on delivery') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="cash_on_delivery"
                                                    class="form-control @error('cash_on_delivery') is-invalid @enderror"
                                                    name="cash_on_delivery" type="checkbox"
                                                    {{ setting('cash_on_delivery') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('cash_on_delivery')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="paymob">{{ __('paymob') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="paymob"
                                                    class="form-control @error('paymob') is-invalid @enderror"
                                                    name="paymob" type="checkbox"
                                                    {{ setting('paymob') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('paymob')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="upayment">{{ __('upayment') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="upayment"
                                                    class="form-control @error('upayment') is-invalid @enderror"
                                                    name="upayment" type="checkbox"
                                                    {{ setting('upayment') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('upayment')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="paypal">{{ __('paypal') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="paypal"
                                                    class="form-control @error('paypal') is-invalid @enderror"
                                                    name="paypal" type="checkbox"
                                                    {{ setting('paypal') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('paypal')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    {{-- <div class="mb-3">
                                        <label class="form-label"
                                            for="compression_ratio">{{ __('Image Compression Ratio') }}</label>
                                        <input name="compression_ratio"
                                            class="form-control @error('compression_ratio') is-invalid @enderror"
                                            value="{{ setting('compression_ratio') }}" type="number" autocomplete="on"
                                            id="compression_ratio" />
                                        @error('compression_ratio')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}







                                </div>

                                <div class="tab-pane fade show " id="tab-social" role="tabpanel"
                                    aria-labelledby="general-tab">

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="snapchat_pixel_id">{{ __('snapchat pixel ID') }}</label>
                                        <input name="snapchat_pixel_id"
                                            class="form-control @error('snapchat_pixel_id') is-invalid @enderror"
                                            type="text" id="snapchat_pixel_id"
                                            value="{{ setting('snapchat_pixel_id') }}">
                                        @error('snapchat_pixel_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="snapchat_token">{{ __('snapchat token') }}</label>
                                        <input name="snapchat_token"
                                            class="form-control @error('snapchat_token') is-invalid @enderror"
                                            type="text" id="snapchat_token" value="{{ setting('snapchat_token') }}">
                                        @error('snapchat_token')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="hotjar_id">{{ __('Hotjar ID') }}</label>
                                        <input name="hotjar_id"
                                            class="form-control @error('hotjar_id') is-invalid @enderror" type="text"
                                            id="hotjar_id" value="{{ setting('hotjar_id') }}">
                                        @error('hotjar_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="google_analytics_id">{{ __('google analytics id') }}</label>
                                        <input name="google_analytics_id"
                                            class="form-control @error('google_analytics_id') is-invalid @enderror"
                                            type="text" id="google_analytics_id"
                                            value="{{ setting('google_analytics_id') }}">
                                        @error('google_analytics_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="tiktok_id">{{ __('tiktok pixel id') }}</label>
                                        <input name="tiktok_id"
                                            class="form-control @error('tiktok_id') is-invalid @enderror" type="text"
                                            id="tiktok_id" value="{{ setting('tiktok_id') }}">
                                        @error('tiktok_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="tiktok_token">{{ __('tiktok pixel token') }}</label>
                                        <input name="tiktok_token"
                                            class="form-control @error('tiktok_token') is-invalid @enderror"
                                            type="text" id="tiktok_token" value="{{ setting('tiktok_token') }}">
                                        @error('tiktok_token')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="facebook_id">{{ __('facebook pixel id') }}</label>
                                        <input name="facebook_id"
                                            class="form-control @error('facebook_id') is-invalid @enderror"
                                            type="text" id="facebook_id" value="{{ setting('facebook_id') }}">
                                        @error('facebook_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="facebook_token">{{ __('facebook token') }}</label>
                                        <input name="facebook_token"
                                            class="form-control @error('facebook_token') is-invalid @enderror"
                                            type="text" id="facebook_token" value="{{ setting('facebook_token') }}">
                                        @error('facebook_token')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="tagmanager_id">{{ __('google tag manager id') }}</label>
                                        <input name="tagmanager_id"
                                            class="form-control @error('tagmanager_id') is-invalid @enderror"
                                            type="text" id="tagmanager_id" value="{{ setting('tagmanager_id') }}">
                                        @error('tagmanager_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="tab-pane fade show" id="tab-notifications" role="tabpanel"
                                    aria-labelledby="notifications-tab">


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="clients_notifications">{{ __('clients notifications') }}</label>

                                        <select
                                            class="form-select js-choice @error('clients_notifications') is-invalid @enderror"
                                            aria-label="" name="clients_notifications[]" multiple id="income_tax">
                                            <option value="">{{ __('select roles') }}</option>

                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ is_array(unserialize(setting('clients_notifications'))) && in_array($role->name, unserialize(setting('clients_notifications'))) ? 'selected' : '' }}>
                                                    {{ __($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('clients_notifications')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="stock_notifications">{{ __('stock notifications') }}</label>

                                        <select
                                            class="form-select js-choice @error('stock_notifications') is-invalid @enderror"
                                            aria-label="" name="stock_notifications[]" multiple id="income_tax">
                                            <option value="">{{ __('select roles') }}</option>

                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ is_array(unserialize(setting('stock_notifications'))) && in_array($role->name, unserialize(setting('stock_notifications'))) ? 'selected' : '' }}>
                                                    {{ __($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('stock_notifications')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="orders_notifications">{{ __('orders notifications') }}</label>

                                        <select
                                            class="form-select js-choice @error('orders_notifications') is-invalid @enderror"
                                            aria-label="" name="orders_notifications[]" multiple id="income_tax">
                                            <option value="">{{ __('select roles') }}</option>

                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ is_array(unserialize(setting('orders_notifications'))) && in_array($role->name, unserialize(setting('orders_notifications'))) ? 'selected' : '' }}>
                                                    {{ __($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('orders_notifications')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="messages_notifications">{{ __('messages notifications') }}</label>

                                        <select
                                            class="form-select js-choice @error('messages_notifications') is-invalid @enderror"
                                            aria-label="" name="messages_notifications[]" multiple id="income_tax">
                                            <option value="">{{ __('select roles') }}</option>

                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ is_array(unserialize(setting('messages_notifications'))) && in_array($role->name, unserialize(setting('messages_notifications'))) ? 'selected' : '' }}>
                                                    {{ __($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('messages_notifications')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="withdrawals_notifications">{{ __('withdrawals notifications') }}</label>

                                        <select
                                            class="form-select js-choice @error('withdrawals_notifications') is-invalid @enderror"
                                            aria-label="" name="withdrawals_notifications[]" multiple id="income_tax">
                                            <option value="">{{ __('select roles') }}</option>

                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ is_array(unserialize(setting('withdrawals_notifications'))) && in_array($role->name, unserialize(setting('withdrawals_notifications'))) ? 'selected' : '' }}>
                                                    {{ __($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('withdrawals_notifications')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>





                                </div>

                            </div>




                            @if (auth()->user()->hasPermission('settings-update'))
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                        name="submit">{{ __('Save') }}</button>
                                </div>
                            @endif
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
