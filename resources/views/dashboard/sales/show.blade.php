@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3 no-print">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    <h5 class="mb-2 mb-md-0">{{ __('Order ') }}{{ $order->serial }}</h5>
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
                    <h2 class="mb-3">
                        @if ($order->order_type == 'Q')
                            {{ __('quotation') }}
                        @elseif($order->order_type == 'SO')
                            {{ __('sales order') }}
                        @endif
                    </h2>
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
                    <h6 class="text-500">{{ __('Customer Information') }}</h6>
                    <h5>{{ $order->full_name }}</h5>
                    <p class="fs--1">
                        {{-- {{ __('Name:') . $order->customer->name }}<br> --}}

                        @if ($order->country_id)
                            {{ __('Country:') . ' ' . getName($order->country) }}<br>
                        @endif

                        @if ($order->country_id)
                            {{ __('Email:') . ' ' . $order->customer->email }}<br>
                        @endif

                        @if ($order->country_id)
                            {{ __('Phone:') . ' ' }} <a
                                href="tel:{{ $order->customer->phone }}">{{ $order->customer->phone }}</a> <br>
                        @endif



                    </p>
                    {{-- <p class="fs--1"><a href="tel:{{ $order->customer->phone }}">{{ $order->customer->phone }}</a>
                    </p> --}}
                </div>
                <div class="col-sm-auto ms-auto">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless fs--1">
                            <tbody>
                                <tr>
                                    <th class="text-sm-end">{{ __('Order Number:') }}</th>
                                    <td>{{ $order->serial }}</td>
                                </tr>
                                <tr>
                                    <th class="text-sm-end">{{ __('Invoice Date:') }}</th>
                                    <td>{{ $order->created_at }}</td>
                                </tr>

                                <tr>
                                    <th class="text-sm-end">{{ __('The qoutation is valid until:') }}</th>
                                    <td>{{ $order->expiration_date }}</td>
                                </tr>

                                <tr class="alert-success fw-bold">
                                    <th class="text-sm-end">{{ __('Total Price:') }}</th>
                                    <td>{{ $order->total_price + $order->shipping_amount . ' ' . $order->currency->symbol }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="table-responsive scrollbar mt-4 fs--1">
                <table class="table table-striped border-bottom">
                    <thead class="light">
                        <tr style="background-color: {{ websiteSettingAr('primary_color') }}"
                            class=" text-white dark__bg-1000">
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


                                    {{-- @if ($product->product_type == 'variable' || $product->product_type == 'simple')
                                        <span class="badge badge-soft-info">
                                            Serial:{{ getProductSerial($product->pivot->product_combination_id, $order->id) }}
                                        </span>
                                    @endif

                                    <span class="badge badge-soft-info">
                                        @if ($product->product_type == 'digital' || $product->product_type == 'service')
                                            SKU:{{ $product->sku }}
                                        @else
                                            SKU:{{ getCombination($product->pivot->product_combination_id)->sku }}
                                        @endif
                                    </span> --}}


                                    @if ($product->pivot->start_date != null && $product->can_rent != null)
                                        <span
                                            class="badge badge-soft-info">{{ __('Rental start date') . ': ' . $product->pivot->start_date }}</span>
                                        <span style="font-size: 11px"
                                            class="badge badge-soft-info">{{ __('No. of Days:') . ' ' . $product->pivot->days }}</span>
                                        <span style="font-size: 11px"
                                            class="badge badge-soft-info">{{ __('Rental end date') . ': ' . $product->pivot->end_date }}</span>
                                        <span style="font-size: 11px"
                                            class="badge badge-soft-info">{{ __('Note') . ': ' . __('rental day = 12 Hours') }}</span>
                                    @endif


                                </td>
                                <td class="align-middle text-center">
                                    {{ $product->pivot->qty . ' ' . getName(getUnitByID($product->pivot->unit_id)) }}</td>
                                <td class="align-middle text-end">
                                    {{ $product->pivot->product_price * $product->pivot->days . ' ' . $order->currency->symbol }}
                                </td>
                                <td class="align-middle text-end">
                                    {{ $product->pivot->total . ' ' . $order->currency->symbol }}</td>
                                {{-- <td class="align-middle text-end">
                                    {{ $product->pivot->commission_per_item . ' ' . $order->currency->symbol }}</td>
                                <td class="align-middle text-end">
                                    {{ $product->pivot->profit_per_item . ' ' . $order->currency->symbol }}</td> --}}
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
                            <td class="fw-semi-bold">
                                {{ $order->subtotal_price . ' ' . $order->currency->symbol }}
                            </td>
                        </tr>


                        <tr>
                            <th class="text-900">{{ __('discount') }}</th>
                            <td class="fw-semi-bold">{{ $order->discount_amount * -1 . ' ' . $order->currency->symbol }}
                            </td>
                        </tr>

                        @foreach ($order->taxes as $tax)
                            <tr>
                                <th class="text-sm-end">{{ getName($tax) }}</th>
                                <td>{{ $tax->pivot->amount . ' ' . $order->currency->symbol }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <th class="text-900">{{ __('shipping fees') }}</th>
                            <td class="fw-semi-bold">{{ $order->shipping_amount . ' ' . $order->currency->symbol }}</td>
                        </tr>


                        <tr class="alert-success fw-bold">
                            <th class="text-sm-end">{{ __('Total:') }}</th>
                            <td>{{ $order->total_price + $order->shipping_amount . ' ' . $order->currency->symbol }}</td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 content-block">
                    <h4>{{ __('General Conditions') }}</h4>
                    <p>
                        {!! $order->notes !!}
                    </p>
                </div>
            </div>

        </div>

        <div class="card-footer bg-light">
            <p class="fs--1 mb-0">

                {{ Request::root() }}
                {{ app()->getLocale() == 'ar' ? websiteSettingAr('footer_address') : websiteSettingEn('footer_address') }}

            </p>
        </div>
    </div>


    <style>
        .card-footer {
            font-size: 15px;
            color: {{ websiteSettingAr('primary_color') }};
            padding: 20px;
        }

        @page {
            size: A4;
            margin: 11mm 17mm 17mm 17mm;
        }

        @media print {
            .card-footer {
                position: fixed;
                bottom: 0;
            }

            .content-block,
            p {
                page-break-inside: avoid;

            }

            .content-block {
                padding: 50px;
                margin-top: 50px;
                margin-bottom: 50px;
            }

            html,
            body {
                width: 210mm;
                height: 297mm;
            }
        }
    </style>
@endsection
