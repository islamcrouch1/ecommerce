@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between">
                <div class="col-md-auto">
                    <h5 class="mb-3 mb-md-0">{{ __('Shopping Cart') }} ({{ Auth::user()->cart->products->count() }}
                        {{ __('Items') }})</h5>
                </div>
                <div class="col-md-auto"><a class="btn btn-sm btn-outline-secondary border-300 me-2"
                        href="{{ route('affiliate.products.index') }}"> <span class="fas fa-chevron-left me-1"
                            data-fa-transform="shrink-4"></span>{{ __('Continue Shopping') }}</a><a
                        class="btn btn-sm btn-primary" href="#checkout-form">{{ __('Checkout') }}</a></div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Quantity') }}</th>
                            <th scope="col">{{ __('Price') }}</th>
                            <th scope="col">{{ __('Commission') }}</th>
                            <th class="text-end" scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->cart->products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center"><a
                                            href="{{ route('affiliate.products.product', ['product' => $product->id]) }}"><img
                                                class="img-fluid rounded-1 me-3 d-none d-md-block"
                                                src="{{ asset('storage/images/products/' . ($product->images->count() == 0 ? 'place-holder.png' : $product->images[0]->image)) }}"
                                                alt="" width="60" /></a>
                                        <div class="flex-1">
                                            <h5 class="fs-0"><a class="text-900"
                                                    href="{{ route('affiliate.products.product', ['product' => $product->id]) }}">
                                                    {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                                    <span class="badge badge-soft-light">
                                                        @if ($product->pivot->product_type == '0')
                                                            {{ app()->getLocale() == 'ar' ? $product->stocks->find($product->pivot->stock_id)->color->color_ar : $product->stocks->find($product->pivot->stock_id)->color->color_en }}
                                                        @else
                                                            {{ app()->getLocale() == 'ar' ? $product->astocks->find($product->pivot->stock_id)->color->color_ar : $product->astocks->find($product->pivot->stock_id)->color->color_en }}
                                                        @endif
                                                    </span>
                                                    <span class="badge badge-soft-light">
                                                        @if ($product->pivot->product_type == '0')
                                                            {{ app()->getLocale() == 'ar' ? $product->stocks->find($product->pivot->stock_id)->size->size_ar : $product->stocks->find($product->pivot->stock_id)->size->size_en }}
                                                        @else
                                                            {{ app()->getLocale() == 'ar' ? $product->astocks->find($product->pivot->stock_id)->size->size_ar : $product->astocks->find($product->pivot->stock_id)->size->size_en }}
                                                        @endif
                                                    </span>
                                                </a>
                                            </h5>
                                            {{-- <div class="fs--2 fs-md--1"><a class="text-danger"
                                                href="">Remove</a>
                                        </div> --}}
                                        </div>
                                    </div>
                                </td>
                                <td>

                                    <div class="input-group input-group-sm" data-quantity="data-quantity">
                                        <button class="btn btn-sm btn-outline-secondary border-300 cart-quantity"
                                            data-field="input-quantity" data-type="minus"
                                            data-stock_id="{{ $product->pivot->stock_id }}">-</button>
                                        <input
                                            class="form-control text-center input-spin-none quantity-{{ $product->pivot->stock_id }}"
                                            data-url="{{ route('cart.change', ['stock_id' => $product->pivot->stock_id]) }}"
                                            type="number" name="quantity" min="1"
                                            value="{{ $product->pivot->quantity }}"
                                            aria-label="Amount (to the nearest dollar)" style="max-width: 50px" />
                                        <button class="btn btn-sm btn-outline-secondary border-300 cart-quantity"
                                            data-field="input-quantity" data-type="plus"
                                            data-stock_id="{{ $product->pivot->stock_id }}">+</button>
                                    </div>
                                </td>
                                <td>{{ $product->pivot->price . ' ' . $user->country->currency }}</td>
                                <td>{{ $product->pivot->price - $product->price . ' ' . $user->country->currency }}</td>
                                <td class="text-end">
                                    <div>
                                        <a href="{{ route('cart.destroy', ['product' => $product->id, 'stock' => $product->pivot->stock_id]) }}"
                                            class="btn p-0 ms-2" type="button" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><span
                                                class="text-500 fas fa-trash-alt"></span></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{-- <div class="row fw-bold gx-card mx-0">
                <div class="col-9 col-md-8 py-2 text-end text-900">{{ __('Total') }}</div>
                <div class="col px-0">
                    <div class="row gx-card mx-0">
                        <div class="col-md-8 py-2 d-none d-md-block text-center">
                            {{ Auth::user()->cart->products->count() }} ({{ __('items') }})</div>
                        <div class="col-12 col-md-4 text-end py-2">
                            {{ calculateCartTotal($user->cart) . ' ' . $user->country->currency }}</div>
                    </div>
                </div>
            </div> --}}
        </div>
        {{-- <div class="card-footer bg-light d-flex justify-content-end">
            <form class="me-3">
                <div class="input-group input-group-sm">
                    <input class="form-control" type="text" placeholder="Promocode" />
                    <button class="btn btn-outline-secondary border-300 btn-sm" type="submit">Apply</button>
                </div>
            </form><a class="btn btn-sm btn-primary" href="../../app/e-commerce/checkout.html">Checkout</a>
        </div> --}}
    </div>


    <div class="card mb-3 mt-3" id="checkout-form"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Order Information') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('affiliate.orders.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">{{ __('Customer Name') . ' *' }}</label>
                                <input name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" type="text" autocomplete="on" id="name" autofocus
                                    required />
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="address">{{ __('Address') . ' *' }}</label>
                                <input name="address" class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address') }}" type="text" autocomplete="on" id="address"
                                    required />
                                @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="house">{{ __('House No') }}</label>
                                <input name="house" class="form-control @error('house') is-invalid @enderror"
                                    value="{{ old('house') }}" type="text" autocomplete="on" id="house" />
                                @error('house')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="special_mark">{{ __('Special Mark') }}</label>
                                <input name="special_mark"
                                    class="form-control @error('special_mark') is-invalid @enderror"
                                    value="{{ old('special_mark') }}" type="text" autocomplete="on"
                                    id="special_mark" />
                                @error('special_mark')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="shipping">{{ __('Shipping to') . ' *' }}</label>
                                <select class=" form-control @error('shipping') is-invalid @enderror" id="shipping"
                                    name="shipping" value="{{ old('shipping') }}" required>
                                    @foreach ($rates as $rate)
                                        <option value="{{ $rate->id }}">
                                            {{ app()->getLocale() == 'ar' ? $rate->city_ar : $rate->city_en }}
                                            {{ ' - ' . $rate->cost . ' ' . $rate->country->currency }}</option>
                                    @endforeach
                                </select>
                                @error('shipping')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone1">{{ __('Phone') . ' *' }}</label>
                                <input name="phone1" class="form-control @error('phone1') is-invalid @enderror"
                                    value="{{ old('phone1') }}" type="text" autocomplete="on" id="phone1"
                                    required />
                                @error('phone1')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone2">{{ __('Alternate Phone') }}</label>
                                <input name="phone2" class="form-control @error('phone2') is-invalid @enderror"
                                    value="{{ old('phone2') }}" type="text" autocomplete="on" id="phone2" />
                                @error('phone2')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="notes">{{ __('notes') }}</label>
                                <input name="notes" class="form-control @error('notes') is-invalid @enderror"
                                    value="{{ old('notes') }}" type="text" autocomplete="on" id="notes" />
                                @error('notes')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New Order') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
