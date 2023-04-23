@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3 no-print">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    <h5 class="mb-2 mb-md-0">{{ __('Order #') }}{{ $order->id }}</h5>
                </div>
                <div class="col-auto">
                    <button onclick="printInvoice();" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"
                        type="button"><span class="fas fa-print me-1"> </span>{{ __('Print') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-center text-center mb-3">
                <div class="col-sm-6 text-sm-start"><img src="{{ asset(websiteSettingMedia('header_logo')) }}"
                        alt="invoice" width="150" /></div>
                <div class="col text-sm-end mt-3 mt-sm-0">
                    <h2 class="mb-3">{{ __('Purchase Invoice') }}</h2>
                    <h5>{{ Request::root() }}</h5>
                    <p class="fs--1 mb-0">
                        {{ app()->getLocale() == 'ar' ? websiteSettingAr('footer_address') : websiteSettingEn('footer_address') }}
                    </p>
                    <p class="fs--1 mb-0">
                        {{ __('Phone:') . ' ' . (websiteSettingAr('header_phone') != null ? websiteSettingAr('header_phone') : websiteSettingAr('footer_phone')) }}
                    </p>
                    <p class="fs--1 mb-0">{{ __('Email:') . ' ' . websiteSettingAr('footer_email') }} </p>
                </div>
                <div class="col-12">
                    <hr />
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="text-500">{{ __('Supplier Information') }}</h6>
                    <h5>{{ $order->full_name }}</h5>
                    <p class="fs--1">
                        {{ __('Name:') . $order->customer->name }}<br>

                        @if ($order->country_id)
                            {{ __('Country:') . ' ' . getName($order->country) }}<br>
                        @endif



                    </p>
                    <p class="fs--1"><a href="tel:{{ $order->customer->phone }}">{{ $order->customer->phone }}</a>
                    </p>
                </div>
                <div class="col-sm-auto ms-auto">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless fs--1">
                            <tbody>
                                <tr>
                                    <th class="text-sm-end">{{ __('Order Number:') }}</th>
                                    <td>#{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th class="text-sm-end">{{ __('Invoice Date:') }}</th>
                                    <td>{{ $order->created_at }}</td>
                                </tr>

                                <tr class="alert-success fw-bold">
                                    <th class="text-sm-end">{{ __('Total Price:') }}</th>
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
                            <th class="border-0">{{ __('Products') }}</th>
                            <th class="border-0 text-center">{{ __('Quantity') }}</th>
                            <th class="border-0 text-end">{{ __('Item Price') }}</th>
                            <th class="border-0 text-end">{{ __('Total Price') }}</th>
                            {{-- <th class="border-0 text-end">{{ __('Affiliate Profit') }}</th>
                            <th class="border-0 text-end">{{ __('plateform Profit') }}</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $product)
                            <tr>
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">
                                        {{ getProductName($product, getCombination($product->pivot->product_combination_id)) }}
                                    </h6>


                                    <span class="badge badge-soft-info">
                                        @if ($product->product_type == 'digital' || $product->product_type == 'service')
                                            SKU:{{ $product->sku }}
                                        @else
                                            SKU:{{ getCombination($product->pivot->product_combination_id)->sku }}
                                        @endif
                                    </span>
                                </td>
                                <td class="align-middle text-center">{{ $product->pivot->qty }}</td>
                                <td class="align-middle text-end">
                                    {{ $product->pivot->product_price . ' ' . $product->country->currency }}</td>
                                <td class="align-middle text-end">
                                    {{ $product->pivot->total . ' ' . $product->country->currency }}</td>
                                {{-- <td class="align-middle text-end">
                                    {{ $product->pivot->commission_per_item . ' ' . $product->country->currency }}</td>
                                <td class="align-middle text-end">
                                    {{ $product->pivot->profit_per_item . ' ' . $product->country->currency }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row justify-content-end">
                <div class="col-auto">
                    <table class="table table-sm table-borderless fs--1 text-end">
                        <tr>
                            <th class="text-900">{{ __('Total Without Tax:') }}</th>
                            <td class="fw-semi-bold">{{ $order->subtotal_price . ' ' . $order->country->currency }}</td>
                        </tr>
                        <tr>
                            <th class="text-sm-end">{{ __('added value tax') }}</th>
                            <td>{{ $order->total_tax . ' ' . $order->country->currency }}</td>
                        </tr>
                        @if ($order->total_wht_products + $order->total_wht_services > 0)
                            <tr>
                                <th class="text-sm-end">{{ __('withholding and collection tax') }}</th>
                                <td>{{ $order->total_wht_products + $order->total_wht_services . ' ' . $order->country->currency }}
                                </td>
                            </tr>
                        @endif
                        <tr class="alert-success fw-bold">
                            <th class="text-sm-end">{{ __('Total:') }}</th>
                            <td>{{ $order->total_price . ' ' . $order->country->currency }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="card-footer bg-light">
            <p class="fs--1 mb-0"><strong>Notes: </strong>We really appreciate your business and if there’s anything
                else we can do, please let us know!</p>
        </div> --}}
    </div>
@endsection
