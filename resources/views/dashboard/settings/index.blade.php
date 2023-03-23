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
                                <li class="nav-item"><a class="nav-link " id="general-tab" data-bs-toggle="tab"
                                        href="#tab-general" role="tab" aria-controls="tab-general"
                                        aria-selected="true">{{ __('general settings') }}</a></li>
                                <li class="nav-item"><a class="nav-link " id="affiliate-tab" data-bs-toggle="tab"
                                        href="#tab-affiliate" role="tab" aria-controls="tab-affiliate"
                                        aria-selected="true">{{ __('affiliate') }}</a></li>

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
                                            'default liability account for cost of goods sold',
                                            $liability_accounts,
                                            $branch->id,
                                        ) !!}


                                        {!! getDivForAccountsSetting(
                                            'funding_assets_account',
                                            'default funding assets account',
                                            $assets_accounts,
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


                                        {!! getDivForAccountsSetting('expenses_account', 'default expenses account', $expenses_accounts, $branch->id) !!}


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

                                    <div class="mb-3">
                                        <label class="form-label" for="front_modal">{{ __('Front popup') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="front_modal"
                                                    class="form-control @error('front_modal') is-invalid @enderror"
                                                    name="front_modal" type="checkbox"
                                                    {{ setting('front_modal') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('front_modal')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="front_modal_title">{{ __('Front popup - title') }}</label>
                                        <input name="front_modal_title"
                                            class="form-control @error('front_modal_title') is-invalid @enderror"
                                            value="{{ setting('front_modal_title') }}" type="text" autocomplete="on"
                                            id="front_modal_title" />
                                        @error('front_modal_title')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="front_modal_body">{{ __('Front popup - body') }}</label>
                                        <input name="front_modal_body"
                                            class="form-control @error('front_modal_body') is-invalid @enderror"
                                            value="{{ setting('front_modal_body') }}" type="text" autocomplete="on"
                                            id="front_modal_body" />
                                        @error('front_modal_body')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="affiliate_modal">{{ __('Affiliate popup') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="affiliate_modal"
                                                    class="form-control @error('affiliate_modal') is-invalid @enderror"
                                                    name="affiliate_modal" type="checkbox"
                                                    {{ setting('affiliate_modal') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('affiliate_modal')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="affiliate_modal_title">{{ __('Affiliate popup - title') }}</label>
                                        <input name="affiliate_modal_title"
                                            class="form-control @error('affiliate_modal_title') is-invalid @enderror"
                                            value="{{ setting('affiliate_modal_title') }}" type="text"
                                            autocomplete="on" id="affiliate_modal_title" />
                                        @error('affiliate_modal_title')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="affiliate_modal_body">{{ __('Affiliate popup - body') }}</label>
                                        <input name="affiliate_modal_body"
                                            class="form-control @error('affiliate_modal_body') is-invalid @enderror"
                                            value="{{ setting('affiliate_modal_body') }}" type="text"
                                            autocomplete="on" id="affiliate_modal_body" />
                                        @error('affiliate_modal_body')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="mb-3">
                                        <label class="form-label" for="vendor_modal">{{ __('Vendor popup') }}</label>
                                        <div>
                                            <label class="switch">
                                                <input id="vendor_modal"
                                                    class="form-control @error('vendor_modal') is-invalid @enderror"
                                                    name="vendor_modal" type="checkbox"
                                                    {{ setting('vendor_modal') == 'on' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                            @error('vendor_modal')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="vendor_modal_title">{{ __('Vendor popup - title') }}</label>
                                        <input name="vendor_modal_title"
                                            class="form-control @error('vendor_modal_title') is-invalid @enderror"
                                            value="{{ setting('vendor_modal_title') }}" type="text"
                                            autocomplete="on" id="vendor_modal_title" />
                                        @error('vendor_modal_title')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="vendor_modal_body">{{ __('Vendor popup - body') }}</label>
                                        <input name="vendor_modal_body"
                                            class="form-control @error('vendor_modal_body') is-invalid @enderror"
                                            value="{{ setting('vendor_modal_body') }}" type="text" autocomplete="on"
                                            id="vendor_modal_body" />
                                        @error('vendor_modal_body')
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
