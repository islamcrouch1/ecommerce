@extends('layouts.ecommerce.app', ['page_title' => 'Checkout'])
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{{ __('Check out') }}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Check out') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->




    <!-- section start -->
    <section class="section-b-space">
        <div class="container">

            <div class="checkout-page">
                <div class="checkout-form">
                    <form method="POST" action="{{ route('ecommerce.order.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-title">
                                    <h3>{{ __('Billing Details') }}</h3>
                                </div>

                                @php
                                    $address = getAddress();
                                @endphp

                                <div class="row check-out">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">{{ __('full name') . ' *' }}</div>
                                        <input name="name" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ Auth::check() ? Auth::user()->name : ($address ? $address->name : old('name')) }}"
                                            type="text" autocomplete="on" id="name" required />
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">{{ __('phone') . ' *' }}</div>
                                        <input name="phone"
                                            class="form-control phone @error('phone') is-invalid @enderror"
                                            value="{{ Auth::check() ? getPhoneWithoutCode(Auth::user()->phone, Auth::user()->country_id) : ($address ? $address->phone : old('phone')) }}"
                                            type="tel" maxlength="{{ getCountry()->phone_digits }}" autocomplete="on"
                                            id="phone" data-phone_digits="{{ getCountry()->phone_digits }}" required />
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">
                                            {{ __('alternative phone') }}
                                        </div>
                                        <input name="phone2"
                                            class="form-control phone @error('phone2') is-invalid @enderror"
                                            value="{{ $address ? $address->phone2 : old('phone2') . ' ' . __('(optional)') }}"
                                            type="tel" maxlength="{{ getCountry()->phone_digits }}" autocomplete="on"
                                            id="phone2" data-phone_digits="{{ getCountry()->phone_digits }}" />
                                        @error('phone2')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('country') }}</div>
                                        <select
                                            class="form-control country-select @error('country_id') is-invalid @enderror"
                                            id="country_id" name="country_id" data-url="{{ route('country.states') }}"
                                            data-url_shipping="{{ route('ecommerce.shipping') }}" required>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" data-country_id="{{ $country->id }}"
                                                    {{ $country->id == getDefaultCountry()->id ? 'selected' : ($address && $address->country_id == $country->id ? 'selected' : '') }}>
                                                    {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('state') }}</div>
                                        <select class="form-control state-select @error('state_id') is-invalid @enderror"
                                            id="state_id" name="state_id" data-url="{{ route('state.cities') }}" required>

                                        </select>
                                        @error('state_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('city') }}</div>
                                        <select class="form-control city-select @error('city_id') is-invalid @enderror"
                                            id="city_id" name="city_id" required>

                                        </select>
                                        @error('city_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('block') . ' *' }}</div>
                                        <input name="block" class="form-control @error('block') is-invalid @enderror"
                                            value="{{ $address ? $address->block : old('block') }}" type="text"
                                            autocomplete="on" id="block" required />
                                        @error('block')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('street address') . ' *' }}</div>
                                        <input name="address" class="form-control @error('address') is-invalid @enderror"
                                            value="{{ $address ? $address->address : old('address') }}" type="text"
                                            autocomplete="on" id="address" required />
                                        @error('address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    @if (getCountry()->name_en == 'Kuwait' || getCountry()->name_en == 'kuwait')
                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <div class="field-label">{{ __('avenue') . ' ' . __('(optional)') }}</div>
                                            <input name="avenue" class="form-control @error('avenue') is-invalid @enderror"
                                                value="{{ $address ? $address->avenue : old('avenue') }}" type="text"
                                                autocomplete="on" id="avenue" />
                                            @error('avenue')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('house') . ' *' }}</div>
                                        <input name="house" class="form-control @error('house') is-invalid @enderror"
                                            value="{{ $address ? $address->house : old('house') }}" type="text"
                                            autocomplete="on" id="house" required />
                                        @error('house')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('floor number') . ' ' . __('(optional)') }}</div>
                                        <input name="floor_no"
                                            class="form-control @error('floor_no') is-invalid @enderror"
                                            value="{{ $address ? $address->floor_no : old('floor_no') }}" type="text"
                                            autocomplete="on" id="floor_no" />
                                        @error('floor_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    {{-- <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('Preferred delivery time') }}</div>
                                        <select class="form-control @error('delivery_time') is-invalid @enderror"
                                            id="delivery_time" name="delivery_time">

                                            <option value="">{{ __('select delivery time') }}</option>
                                            <option value="morning"
                                                {{ $address && $address->delivery_time == 'morning' ? 'selected' : '' }}>
                                                {{ __('morning') }}</option>
                                            <option value="evening"
                                                {{ $address && $address->delivery_time == 'evening' ? 'selected' : '' }}>
                                                {{ __('evening') }}</option>

                                        </select>
                                        @error('delivery_time')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}


                                    <hr class="style-element">

                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('Please attach your passport or personal ID') }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('passport') . ' ' . __('(optional)') }}</div>
                                        <input name="passport"
                                            class="img form-control @error('passport') is-invalid @enderror"
                                            type="file" accept="image/*" id="passport" />
                                        @error('passport')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('Emirati ID') . ' ' . __('(optional)') }}</div>
                                        <input name="id" class="img form-control @error('id') is-invalid @enderror"
                                            type="file" accept="image/*" id="id" />
                                        @error('id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">
                                            {{ __('If filming is in an outdoor location, please attach a filming Permit') }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('filming Permit') . ' ' . __('(optional)') }}</div>
                                        <input name="permit"
                                            class="img form-control @error('permit') is-invalid @enderror" type="file"
                                            accept="image/*" id="permit" />
                                        @error('permit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('notes') }}</div>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4"
                                            cols="50"></textarea>
                                        @error('notes')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    @if (!Auth::check())
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="checkbox" value="create_account" name="create_account"
                                                id="account-option"> &ensp;
                                            <label for="account-option">{{ __('Create An Account?') }}</label>
                                        </div>
                                    @endif


                                    <div style="display:none"
                                        class="form-group col-md-12 col-sm-6 col-xs-12 checkout-password">
                                        <div class="field-label">{{ __('Email') }}</div>
                                        <input
                                            class="form-control checkout-password-password @error('email') is-invalid @enderror"
                                            type="email" autocomplete="on" id="email" name="email" />
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div style="display:none"
                                        class="form-group col-md-6 col-sm-6 col-xs-12 checkout-password">
                                        <div class="field-label">{{ __('Password') }}</div>
                                        <input
                                            class="form-control checkout-password-password @error('password') is-invalid @enderror"
                                            type="password" autocomplete="on" id="password" name="password" />
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div style="display:none"
                                        class="form-group col-md-6 col-sm-6 col-xs-12 checkout-password">
                                        <div class="field-label">{{ __('Confirm Password') }}</div>
                                        <input
                                            class="form-control checkout-password-password-confirm @error('password_confirmation') is-invalid @enderror"
                                            type="password" autocomplete="on" id="password_confirmation"
                                            name="password_confirmation" />
                                        @error('password_confirmation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div style="display:none" class="checkout-password">
                                        <span class="p-4" for="check">{{ __('I accept the') }} <a
                                                href="{{ route('ecommerce.terms') }}">{{ __('terms') }}
                                            </a>{{ __('and') }} <a
                                                href="{{ route('ecommerce.terms') }}">{{ __('privacy policy') }}</a></span>
                                    </div>




                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <div>{{ __('Products') }} <span>{{ __('Total') }}</span></div>
                                        </div>
                                        <ul class="qty">
                                            @foreach ($cart_items as $item)
                                                <li>
                                                    <div style="width:300px; display:inline-block">
                                                        {{ getProductName($item->product, getCombination($item->product_combination_id)) }}
                                                        × {{ $item->qty }}





                                                        @php
                                                            $warehouses = getWebsiteWarehouses();
                                                            $branch_id = setting('website_branch');
                                                            if ($item->product->vendor_id == null) {
                                                                $av_qty = productQuantityWebsite(
                                                                    $item->product->id,
                                                                    $item->combination->id,
                                                                    null,
                                                                    $warehouses,
                                                                );
                                                            } else {
                                                                $warehouse_vendor = App\Models\Warehouse::where(
                                                                    'vendor_id',
                                                                    $item->product->vendor_id,
                                                                )->first();
                                                                $av_qty = productQuantity(
                                                                    $item->product->id,
                                                                    null,
                                                                    $warehouse_vendor->id,
                                                                );
                                                            }
                                                        @endphp

                                                        @if ($item->qty > $av_qty)
                                                            <p style="display: inline-block" class="m-1 primary-color">
                                                                {{ __('out of stock') }}</p>
                                                        @endif


                                                    </div>
                                                    <span>{{ productPrice($item->product, $item->product_combination_id, 'vat') * $item->qty * $item->days . getCurrency() }}</span>
                                                </li>

                                                @if ($item->start_date != null && $item->product->can_rent != null)
                                                    <span
                                                        class="badge bg-info rental-span">{{ __('Rental start date') . ' ' . $item->start_date }}</span>
                                                    <span
                                                        class="badge bg-info rental-span">{{ __('No. of Days:') . ' ' . $item->days }}</span>
                                                    <span
                                                        class="badge bg-info rental-span">{{ __('Rental end date') . ': ' . $item->end_date }}</span>
                                                    <span
                                                        class="badge bg-info rental-span">{{ __('Note') . ': ' . __('rental day = 12 Hours') }}</span>
                                                @endif
                                            @endforeach
                                        </ul>
                                        <ul class="sub-total">
                                            <li>{{ __('Subtotal') }} <span
                                                    class="count">{{ getCartSubtotal($cart_items) . getCurrency() }}</span>
                                            </li>
                                            <li>{{ __('Shipping') }}
                                                <div class="shipping">

                                                    @if (setting('shipping_method') != '2')
                                                        <div class="shopping-option shipping-option-1">
                                                            <input data-total="{{ getCartSubtotal($cart_items) }}"
                                                                value="1" type="radio" name="shipping_option"
                                                                id="shipping_option" required>
                                                            <label for="shipping_option"><span class="shipping-amount">0
                                                                    {{ getCurrency() }}</span></label>
                                                        </div>
                                                    @endif

                                                    @if (setting('locale_pickup') == 'on' || setting('shipping_method') == '2')
                                                        <div class="shopping-option shipping-option-2">
                                                            <input value="2" type="radio" name="shipping_option"
                                                                id="local_pickup" required>
                                                            <label for="local-pickup">{{ __('Local Pickup') }}</label>
                                                        </div>
                                                    @endif


                                                    <div style="display: none;"
                                                        class="form-group select-branch col-md-12 col-sm-12 col-xs-12">
                                                        <select
                                                            class="form-control select-branch-input @error('branch_id') is-invalid @enderror"
                                                            id="branch_id" name="branch_id">
                                                            <option value="">
                                                                {{ __('Choose the branch closest to you') }}</option>

                                                            @foreach (getAllBranches() as $branch)
                                                                <option value="{{ $branch->id }}">
                                                                    {{ getName($branch) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div style="display:none !important"
                                                        class="alert alert-info border-2 align-items-center alarm"
                                                        role="alert">

                                                        <p class="mb-0 flex-1 alarm-text"></p>
                                                    </div>



                                                </div>
                                            </li>
                                        </ul>
                                        @if (getCartItems()->count() > 0)
                                            <div class="row">
                                                <div class="col-md-12 mt-2 mb-2">
                                                    <a class="coupon-link"
                                                        href="">{{ __('Have a promo code?') }}</a>
                                                </div>

                                                <div style="display: none" class="col-md-6 mt-2 mb-2 coupon-field">
                                                    <div class="input-group mb-1">
                                                        <input style="width:60%" type="text"
                                                            class="form-control coupon-code">
                                                        <button class="btn btn-outline-secondary coupon-apply"
                                                            type="button"
                                                            id="button-addon2">{{ __('apply') }}</button>
                                                    </div>

                                                    <input style="display: none" name="coupon" style="width:60%"
                                                        type="text" class="form-control coupon-submit">

                                                </div>



                                                <div style="display: none" class="col-md-2 coupon-remove mt-2 mb-2">
                                                    <button class="btn-solid btn"><i class="fa fa-trash"
                                                            aria-hidden="true"></i>
                                                    </button>
                                                </div>

                                                <div class="col-md-12 mt-1 mb-2">
                                                    <span class="coupon-text"></span>
                                                </div>


                                            </div>
                                        @endif


                                        </ul>
                                        <ul class="total">
                                            <li>{{ __('Discount') }} <span
                                                    class="count checkout-discount">{{ 0 . getCurrency() }}
                                                </span>
                                            </li>
                                            <li>{{ __('Total') }} <span
                                                    class="count checkout-total">{{ getCartSubtotal($cart_items) . getCurrency() }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="payment-box">
                                        <div class="upper-box">
                                            <div class="payment-options">
                                                <ul>
                                                    {{-- <li>
                                                        <div class="radio-option">
                                                            <input type="radio" name="payment-group" id="payment-1"
                                                                checked="checked">
                                                            <label for="payment-1">Check Payments<span
                                                                    class="small-text">Please send a check to Store
                                                                    Name, Store Street, Store Town, Store State /
                                                                    County, Store Postcode.</span></label>
                                                        </div>
                                                    </li> --}}

                                                    @if (setting('cash_on_delivery'))
                                                        <li>
                                                            <div class="radio-option">
                                                                <input type="radio" value="cash"
                                                                    name="payment_method" id="payment-1" required>
                                                                <label
                                                                    for="payment-1">{{ __('Cash On Delivery') }}</label>
                                                            </div>
                                                        </li>
                                                    @endif


                                                    @if (setting('paymob'))
                                                        <li>
                                                            <div class="radio-option">
                                                                <input type="radio" value="paymob"
                                                                    name="payment_method" id="payment-2" required>
                                                                <label
                                                                    for="payment-2">{{ __('Visa and MasterCard') . ' via paymob' }}</label>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    @if (setting('upayment'))
                                                        <li>
                                                            <div class="radio-option">
                                                                <input type="radio" value="upayment"
                                                                    name="payment_method" id="payment-2" required>
                                                                <label
                                                                    for="payment-2">{{ __('Visa and MasterCard') . ' via upayment' }}</label>
                                                            </div>
                                                        </li>
                                                    @endif


                                                    @if (setting('paypal'))
                                                        <li>
                                                            <div class="radio-option">
                                                                <input type="radio" value="paypal"
                                                                    name="payment_method" id="payment-2" required>
                                                                <label
                                                                    for="payment-2">{{ __('Visa and MasterCard') . ' via paypal' }}</label>
                                                            </div>
                                                        </li>
                                                    @endif



                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" value="agree" name="conditions"
                                                                id="conditions" required>
                                                            <label for="conditions"><span class="p-4"
                                                                    for="check">{{ __('I accept the') }} <a
                                                                        href="{{ route('ecommerce.terms') }}">{{ __('terms') }}
                                                                    </a>{{ __('and') }} <a
                                                                        href="{{ route('ecommerce.terms') }}">{{ __('privacy policy') }}</a></span></label>
                                                        </div>
                                                    </li>

                                                    {{-- <li>
                                                        <div class="radio-option paypal">
                                                            <input type="radio" name="payment-group" id="payment-3">
                                                            <label for="payment-3">PayPal<span class="image"><img
                                                                        src="../assets/images/paypal.png"
                                                                        alt=""></span></label>
                                                        </div>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="text-end"><button type="submit"
                                                class="btn-solid btn">{{ __('Place Order') }}</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->
@endsection
