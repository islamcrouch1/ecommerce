@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    <h5 class="mb-2 mb-md-0">{{ __('Order #') }}{{ $order->id }}</h5>
                </div>
                <div class="col-auto">
                    <button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button"><span
                            class="fas fa-print me-1"> </span>{{ __('Print') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-center text-center mb-3">
                <div class="col-sm-6 text-sm-start"><img src="{{ asset('assets/img/logo-blue.png') }}" alt="invoice"
                        width="150" />
                </div>
                <div class="col text-sm-end mt-3 mt-sm-0">
                    <h2 class="mb-3">Invoice</h2>
                    <h5>
                        سونو ايجي للتسويق والتجارة الالكترونية
                    </h5>
                    <p class="fs--1 mb-0">
                        {{ __('3, 26th of July Street, second floor, Flat 25, in front of Al-Hawari, Lebanon Square, above the pharmacy, Dr. Amira, Al-Muhandseen') }}
                    </p>
                    <p class="fs--1 mb-0">{{ __('Phone:') }}01094666865</p>
                    <p class="fs--1 mb-0">{{ __('Email:') }} info@sonoo.online</p>
                </div>
                <div class="col-12">
                    <hr />
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-500">{{ __('Customer Information') }}</h6>
                    <h5>{{ $order->client_name }}</h5>
                    <p class="fs--1">{{ __('Address:') . $order->address }}<br>
                        @if ($order->house)
                            {{ __('House:') . $order->house }}<br>
                        @endif
                        @if ($order->special_mark)
                            {{ __('Special Mark:') . $order->special_mark }}<br>
                        @endif
                        @if ($order->phone2)
                            {{ __('Alternate Phone:') . $order->phone2 }}<br>
                        @endif
                        {{ __('Notes:') . $order->notes }}<br>
                    </p>
                    <p class="fs--1"><a href="tel:{{ $order->client_phone }}">{{ $order->client_phone }}</a>
                    </p>
                </div>
                <div class="col-sm-auto ms-auto">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless fs--1">
                            <tbody>
                                <tr>
                                    <th class="text-sm-end">Order Number:</th>
                                    <td>#{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th class="text-sm-end">رقم التسجيل الضريبي:</th>
                                    <td>#{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th class="text-sm-end">Invoice Date:</th>
                                    <td>{{ $order->created_at }}</td>
                                </tr>
                                <tr>
                                    <th class="text-sm-end">Shipping Cost:</th>
                                    <td>{{ $order->shipping . ' ' . $order->country->currency }}</td>
                                </tr>
                                <tr class="alert-success fw-bold">
                                    <th class="text-sm-end">Total Price:</th>
                                    <td>{{ $order->total_price . ' ' . $order->country->currency }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="table-responsive scrollbar mt-4 fs--1">
                <table class="table table-striped border-bottom">
                    <thead class="light">
                        <tr class="bg-primary text-white dark__bg-1000">
                            <th class="border-0">Products</th>
                            <th class="border-0 text-center">Quantity</th>
                            <th class="border-0 text-end">Item Price</th>
                            <th class="border-0 text-end">Affiliate Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $product)
                            <tr>
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">
                                        {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h6>
                                    <span class="badge badge-soft-info">
                                        @if ($product->pivot->product_type == '0')
                                            {{ app()->getLocale() == 'ar' ? $product->stocks->find($product->pivot->stock_id)->color->color_ar : $product->stocks->find($product->pivot->stock_id)->color->color_en }}
                                        @else
                                            {{ app()->getLocale() == 'ar' ? $product->astocks->find($product->pivot->stock_id)->color->color_ar : $product->astocks->find($product->pivot->stock_id)->color->color_en }}
                                        @endif
                                    </span>
                                    <span class="badge badge-soft-info">
                                        @if ($product->pivot->product_type == '0')
                                            {{ app()->getLocale() == 'ar' ? $product->stocks->find($product->pivot->stock_id)->size->size_ar : $product->stocks->find($product->pivot->stock_id)->size->size_en }}
                                        @else
                                            {{ app()->getLocale() == 'ar' ? $product->astocks->find($product->pivot->stock_id)->size->size_ar : $product->astocks->find($product->pivot->stock_id)->size->size_en }}
                                        @endif
                                    </span>

                                    <span class="badge badge-soft-info">
                                        SKU:{{ $product->sku }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">{{ $product->pivot->quantity }}</td>
                                <td class="align-middle text-end">
                                    {{ $product->pivot->selling_price . ' ' . $product->country->currency }}</td>
                                <td class="align-middle text-end">
                                    {{ $product->pivot->commission_per_item . ' ' . $product->country->currency }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row justify-content-end">
                <div class="col-auto">
                    <table class="table table-sm table-borderless fs--1 text-end">
                        <tr>
                            <th class="text-900">Subtotal:</th>
                            <td class="fw-semi-bold">{{ $order->total_price . ' ' . $order->country->currency }}</td>
                        </tr>
                        <tr>
                            <th class="text-900">Shipping Cost:</th>
                            <td class="fw-semi-bold">{{ $order->shipping . ' ' . $order->country->currency }}</td>
                        </tr>
                        <tr class="border-top">
                            <th class="text-900">Total:</th>
                            <td class="fw-semi-bold">
                                {{ $order->shipping + $order->total_price . ' ' . $order->country->currency }}</td>
                        </tr>
                    </table>
                </div>
                <p>السعر شامل ضريبة القيمة المضافة</p>
            </div>
        </div>
        {{-- <div class="card-footer bg-light">
            <p class="fs--1 mb-0"><strong>Notes: </strong>We really appreciate your business and if there’s anything
                else we can do, please let us know!</p>
        </div> --}}
    </div>
@endsection
