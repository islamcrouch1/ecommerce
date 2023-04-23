@extends('layouts.ecommerce.app', ['page_title' => 'Invoice'])
@section('content')
    <!-- invoice 1 start -->
    <section class="theme-invoice-1 section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 m-auto">
                    <div class="invoice-wrapper">
                        <div class="invoice-header">
                            <div class="upper-icon">
                                <img src="{{ asset('e-assets/images/invoice/invoice.svg') }}" class="img-fluid" alt="">
                            </div>
                            <div style="direction: ltr !important" class="row header-content">
                                <div class="col-md-6">
                                    <img src="{{ asset(websiteSettingMedia('header_logo')) }}" class="img-fluid"
                                        alt="">
                                    <div class="mt-md-4 mt-3">
                                        <h4 class="mb-2">
                                            {{ app()->getLocale() == 'ar' ? websiteSettingAr('website_title') : websiteSettingEn('website_title') }}
                                        </h4>
                                        <h4 class="mb-0">{{ websiteSettingAr('footer_email') }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end mt-md-0 mt-4">
                                    <h2>{{ __('invoice') }}</h2>
                                    <div class="mt-md-4 mt-3">
                                        <h4 class="mb-2">
                                            {{ app()->getLocale() == 'ar' ? websiteSettingAr('footer_address') : websiteSettingEn('footer_address') }}
                                        </h4>

                                    </div>
                                </div>
                            </div>
                            <div class="detail-bottom">
                                <ul>
                                    <li><span>{{ __('issue date :') }}</span>
                                        <h4> {{ $order->created_at }}</h4>
                                    </li>
                                    <li><span>{{ __('order no :') }}</span>
                                        <h4> {{ $order->id }}</h4>
                                    </li>
                                    <li><span>{{ __('user name :') }}</span>
                                        <h4>{{ $order->customer->name }}</h4>
                                    </li>
                                    <li><span>{{ __('phone :') }}</span>
                                        <h4>{{ $order->customer->phone }}</h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="invoice-body table-responsive-md">
                            <table class="table table-borderless mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('product') }}</th>
                                        <th scope="col">{{ __('price') }}</th>
                                        <th scope="col">{{ __('Qty') }}</th>
                                        <th scope="col">{{ __('total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->products as $index => $product)
                                        <tr>
                                            <th scope="row">{{ $index }}</th>
                                            <td>{{ getProductName($product, getCombination($product->pivot->product_combination_id)) }}


                                                @if ($product->product_type == 'digital' && $order->payment_status == 'Paid')
                                                    <a href="{{ route('ecommerce.download', ['product_file' => $product->digital_file]) }}"
                                                        class="btn btn-solid btn-sm btn-xs me-3 m-2"
                                                        type="button">{{ __('Download files') }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $product->pivot->product_price . $order->country->currency }}</td>
                                            <td>{{ $product->pivot->qty }}</td>
                                            <td>{{ $product->pivot->total . $order->country->currency }} </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="font-bold text-dark" colspan="2">{{ __('shipping') }}</td>
                                        <td class="font-bold text-theme">
                                            {{ $order->shipping_amount . $order->country->currency }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="font-bold text-dark" colspan="2">{{ __('discount') }}</td>
                                        <td class="font-bold text-theme">
                                            {{ $order->discount_amount . $order->country->currency }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="font-bold text-dark" colspan="2">{{ __('total') }}</td>
                                        <td class="font-bold text-theme">
                                            {{ $order->total_price . $order->country->currency }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="invoice-footer text-end">
                            {{-- <div class="authorise-sign">
                                <img src="../assets/images/invoice/sign.png" class="img-fluid" alt="sing">
                                <span class="line"></span>
                                <h6>Authorised Sign</h6>
                            </div> --}}
                            <div class="buttons">
                                <a href="#" class="btn black-btn btn-solid rounded-2 me-2"
                                    onclick="window.print();">{{ __('export as PDF') }}</a>
                                <a href="#" class="btn btn-solid rounded-2"
                                    onclick="window.print();">{{ __('print') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- invoice 1 end -->
@endsection
