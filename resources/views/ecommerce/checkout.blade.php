@extends('layouts.ecommerce.app')
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
                    <nav style="direction: ltr; float:{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"
                        aria-label="breadcrumb" class="theme-breadcrumb">
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

            @include('layouts.ecommerce._flash')

            <div class="checkout-page">
                <div class="checkout-form">
                    <form method="POST" action="{{ route('ecommerce.order.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-title">
                                    <h3>{{ __('Billing Details') }}</h3>
                                </div>
                                <div class="row check-out">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">{{ __('full name') }}</div>
                                        <input name="name" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" type="text" autocomplete="on" id="name"
                                            autofocus required />
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">{{ __('phone') }}</div>
                                        <input name="phone" class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}" type="text" autocomplete="on" id="phone"
                                            autofocus required />
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('street address') }}</div>
                                        <input name="address" class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address') }}" type="text" autocomplete="on" id="address"
                                            autofocus required />
                                        @error('address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('country') }}</div>
                                        <select
                                            class="form-control country-select @error('country_id') is-invalid @enderror"
                                            id="country_id" name="country_id" data-url="{{ route('country.states') }}"
                                            data-url_shipping="{{ route('ecommerce.shipping') }}" required>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" data-country_id="{{ $country->id }}"
                                                    {{ $country->id == getDefaultCountry()->id ? 'selected' : '' }}>
                                                    {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('state') }}</div>
                                        <select class="form-control state-select @error('state_id') is-invalid @enderror"
                                            id="state_id" name="state_id" data-url="{{ route('state.cities') }}" required>

                                        </select>
                                        @error('state_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">{{ __('city') }}</div>
                                        <select class="form-control city-select @error('city_id') is-invalid @enderror"
                                            id="city_id" name="city_id" required>

                                        </select>
                                        @error('city_id')
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
                                            <input type="checkbox" value="create-account" name="create-account"
                                                id="account-option"> &ensp;
                                            <label for="account-option">{{ __('Create An Account?') }}</label>
                                        </div>
                                    @endif


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
                                                <li>{{ app()->getLocale() == 'ar' ? $item->product->name_ar : $item->product->name_en }}
                                                    {{ getCProductVariations($item->combination) }} × {{ $item->qty }}
                                                    <span>{{ productPrice($item->product, $item->product_combination_id) * $item->qty . getCurrency() }}</span>
                                                </li>
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
                                                            <option value="1">{{ __('faisal branch') }}</option>
                                                            <option value="1">{{ __('haram branch') }}</option>
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
                                        <ul class="total">
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
                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" value="cash" name="payment_method"
                                                                id="payment-1" required>
                                                            <label for="payment-1">{{ __('Cash On Delivery') }}</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" value="card" name="payment_method"
                                                                id="payment-2" required>
                                                            <label for="payment-2">{{ __('Visa and MasterCard') }}</label>
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
