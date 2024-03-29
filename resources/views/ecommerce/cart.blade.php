@extends('layouts.ecommerce.app', ['page_title' => 'Cart'])
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{{ __('cart') }}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('cart') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->



    <!--section start-->
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                {{-- <div class="col-sm-12">
                    <div class="cart_counter">
                        <div class="countdownholder">
                            Your cart will be expired in<span id="timer"></span> minutes!
                        </div>
                        <a href="checkout.html" class="cart_checkout btn btn-solid btn-xs">check out</a>
                    </div>
                </div> --}}
                <div class="col-sm-12 table-responsive-xs">
                    <table class="table cart-table">
                        <thead>
                            <tr class="table-head">
                                <th class="{{ app()->getLocale() == 'ar' ? 'text-start' : '' }}" scope="col">
                                    {{ __('image') }}</th>
                                <th class="{{ app()->getLocale() == 'ar' ? 'text-start' : '' }}" scope="col">
                                    {{ __('product name') }}</th>
                                <th class="{{ app()->getLocale() == 'ar' ? 'text-start' : '' }}" scope="col">
                                    {{ __('price') }}</th>
                                <th class="{{ app()->getLocale() == 'ar' ? 'text-center' : '' }}" scope="col">
                                    {{ __('quantity') }}</th>
                                <th class="{{ app()->getLocale() == 'ar' ? 'text-start' : '' }}" scope="col">
                                    {{ __('action') }}</th>
                                <th class="{{ app()->getLocale() == 'ar' ? 'text-start' : '' }}" scope="col">
                                    {{ __('total') }}</th>
                            </tr>
                        </thead>
                        @foreach ($cart_items as $item)
                            <tbody>
                                <tr>
                                    <td>
                                        <a
                                            href="{{ route('ecommerce.product', ['product' => $item->product->id, 'slug' => createSlug(getName($item->product))]) }}"><img
                                                src="{{ asset($item->product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $item->product->images[0]->media->path) }}"
                                                alt=""></a>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('ecommerce.product', ['product' => $item->product->id, 'slug' => createSlug(getName($item->product))]) }}">

                                            {{ getProductName($item->product, $item->combination) }}


                                        </a>
                                        <div class="mobile-cart-content row">
                                            <div class="col-12">
                                                <div style="min-width: 150px !important" class="qty-box">
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <button type="button" class="btn quantity-left-minus"
                                                                data-type="minus" data-field=""><i
                                                                    class="ti-angle-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="quantity"
                                                            class="form-control qty-input input-number cart-quantity quantity-{{ $item->product_id }}"
                                                            value="{{ $item->qty }}"
                                                            data-min="{{ $item->product->product_min_order }}"
                                                            data-max="{{ $item->product->product_max_order }}"
                                                            data-id="{{ $item->product_id . '-' . $item->product_combination_id }}"
                                                            data-url={{ route('ecommerce.cart.change', ['product' => $item->product_id, 'combination' => $item->product_combination_id]) }}
                                                            data-currency="{{ getCurrency() }}" disabled>
                                                        <span class="input-group-prepend">
                                                            <button type="button" class="btn quantity-right-plus"
                                                                data-type="plus" data-field=""><i
                                                                    class="ti-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col p-2">
                                                <h2 class="td-color">
                                                    <span
                                                        class="total-{{ $item->product_id . '-' . $item->product_combination_id }}">{{ productPrice($item->product, $item->product_combination_id, 'vat') * $item->qty . getCurrency() }}</span>

                                                </h2>

                                            </div>
                                            <div class="col p-2">
                                                <h2 class="td-color"><a
                                                        href="{{ route('ecommerce.cart.destroy', ['product' => $item->product->id, 'combination' => $item->product_combination_id]) }}"
                                                        class="icon"><i class="ti-close"></i></a>
                                                </h2>
                                            </div>
                                        </div>
                                    </td>



                                    <td>
                                        <h2>{{ productPrice($item->product, $item->product_combination_id, 'vat') . getCurrency() }}
                                        </h2>
                                    </td>
                                    <td>

                                        <div style="min-width: 150px !important" class="qty-box">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn quantity-left-minus" data-type="minus"
                                                        data-field=""><i
                                                            class="ti-angle-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="quantity"
                                                    class="form-control qty-input input-number cart-quantity quantity-{{ $item->product_id }}"
                                                    value="{{ $item->qty }}"
                                                    data-min="{{ $item->product->product_min_order }}"
                                                    data-max="{{ $item->product->product_max_order }}"
                                                    data-id="{{ $item->product_id . '-' . $item->product_combination_id }}"
                                                    data-url={{ route('ecommerce.cart.change', ['product' => $item->product_id, 'combination' => $item->product_combination_id]) }}
                                                    data-currency="{{ getCurrency() }}" disabled>
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn quantity-right-plus" data-type="plus"
                                                        data-field=""><i
                                                            class="ti-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                    </td>
                                    <td><a href="{{ route('ecommerce.cart.destroy', ['product' => $item->product->id, 'combination' => $item->product_combination_id]) }}"
                                            class="icon"><i class="ti-close"></i></a></td>
                                    <td>
                                        <h2 class="td-color">
                                            <span
                                                class="total-{{ $item->product_id . '-' . $item->product_combination_id }}">{{ productPrice($item->product, $item->product_combination_id, 'vat') * $item->qty . getCurrency() }}</span>

                                        </h2>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach

                    </table>
                    <div class="table-responsive-md">
                        <table class="table cart-table ">
                            <tfoot>
                                <tr>
                                    <td>{{ __('discount :') }}</td>
                                    <td>
                                        <h2><span
                                                class="cart-discount">{{ calcDiscount($cart_items) . getCurrency() }}</span>
                                        </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('total price :') }}</td>
                                    <td>
                                        <h2><span
                                                class="cart-total">{{ getCartSubtotal($cart_items) - calcDiscount($cart_items) . getCurrency() }}</span>
                                        </h2>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row cart-buttons">
                <div class="col-6"><a href="{{ route('ecommerce.products') }}"
                        class="btn btn-solid">{{ __('continue shopping') }}</a></div>
                <div class="col-6"><a href="{{ getCartItems()->count() <= 0 ? '#' : route('ecommerce.checkout') }}"
                        class="btn btn-solid">{{ __('check out') }}</a></div>
            </div>
        </div>
    </section>
    <!--section end-->
@endsection
