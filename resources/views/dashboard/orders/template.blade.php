<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>


    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset(websiteSettingMedia('header_icon')) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset(websiteSettingMedia('header_icon')) }}" type="image/x-icon">
    <title>{{ app()->getLocale() == 'ar' ? websiteSettingAr('website_title') : websiteSettingEn('website_title') }}
    </title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <style type="text/css">
        body {
            text-align: center;
            margin: 0 auto;
            width: 650px;
            font-family: 'Open Sans', sans-serif;
            background-color: #e2e2e2;
            display: block;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            display: inline-block;
            text-decoration: unset;
        }

        a {
            text-decoration: none;
        }

        p {
            margin: 15px 0;
        }

        h5 {
            color: #444;
            text-align: left;
            font-weight: 400;
        }

        .text-center {
            text-align: center
        }

        .main-bg-light {
            background-color: #fafafa;
        }

        .title {
            color: #444444;
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 10px;
            padding-bottom: 0;
            text-transform: uppercase;
            display: inline-block;
            line-height: 1;
        }

        table {
            margin-top: 30px
        }

        table.top-0 {
            margin-top: 0;
        }

        table.order-detail,
        .order-detail th,
        .order-detail td {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        .order-detail th {
            font-size: 16px;
            padding: 15px;
            text-align: center;
        }

        .footer-social-icon tr td img {
            margin-left: 5px;
            margin-right: 5px;
        }

        .padding {
            padding: 8px;
        }

        .text-align {
            text-align: left;
        }
    </style>


    @if (app()->getLocale() == 'ar')
        <style>
            p,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            li,
            label,
            input,
            button,
            span,
            select,
            div,
            a {
                font-family: cairo !important;
                letter-spacing: -0.6px !important;
            }

            body {
                direction: rtl;
            }

            .text-align {
                text-align: right !important;
            }
        </style>
    @endif

</head>

<body style="margin: 20px auto;">

    <table align="center" border="0" cellpadding="0" cellspacing="0"
        style="padding: 0 30px;background-color: #fff; -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);width: 100%;">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="padding">
                                <img src="{{ asset('e-assets/images/delivery.png') }}" alt=""
                                    style="margin-bottom: 30px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="padding">
                                <img src="{{ asset('e-assets/images/success.png') }}" alt="">
                            </td>
                        </tr>

                        @if ($type == 'user')
                            <tr>
                                <td class="padding">
                                    <h2 class="title">{{ __('thank you') }}</h2>
                                </td>
                            </tr>

                            <tr>
                                <td class="padding">
                                    <p>{{ __('Your order has been received successfully, and we will contact you as soon as possible') }}
                                    </p>
                                    <p>{{ __('Order ID:') . ' ' . $order->id }}</p>
                                </td>
                            </tr>
                        @endif

                        @if ($type == 'admin')
                        @endif

                        <tr>

                            <td class="padding">
                                <div style="border-top:1px solid #777;height:1px;margin-top: 30px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="padding">
                                <img src="images/order-success.png" alt="" style="margin-top: 30px;">
                            </td>
                        </tr>
                    </table>
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="padding">
                                <h2 class="title">{{ __('YOUR ORDER DETAILS') }}</h2>
                            </td>
                        </tr>
                    </table>
                    <table class="order-detail" border="0" cellpadding="0" cellspacing="0" align="left">
                        <tr align="left">
                            <th>{{ __('PRODUCT') }}</th>
                            <th style="padding-left: 15px;">{{ __('DESCRIPTION') }}</th>
                            <th>{{ __('QUANTITY') }}</th>
                            <th>{{ __('PRICE') }} </th>
                        </tr>


                        @foreach ($order->products as $product)
                            <tr>
                                <td class="padding">
                                    <img src="{{ getProductImage($product) }}" alt="" width="70">
                                </td>
                                <td class="padding" valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;">
                                        {{ getProductName($product, getCombination($product->pivot->product_combination_id)) }}
                                    </h5>

                                    @if ($product->pivot->start_date != null && $product->can_rent != null)
                                        <span
                                            class="badge bg-info rental-span">{{ __('Rental start date') . ' ' . $product->pivot->start_date }}</span><br>
                                        <span
                                            class="badge bg-info rental-span">{{ __('No. of Days:') . ' ' . $product->pivot->days }}</span><br>
                                        <span
                                            class="badge bg-info rental-span">{{ __('Rental end date') . ': ' . $product->pivot->end_date }}</span><br>
                                        <span
                                            class="badge bg-info rental-span">{{ __('Note') . ': ' . __('rental day = 12 Hours') }}</span><br>
                                    @endif

                                </td>
                                <td class="padding" valign="top" style="padding-left: 15px;">

                                    <h5 style="font-size: 14px; color:#444;margin-top: 10px;">QTY :
                                        <span>{{ $product->pivot->qty }}</span>
                                    </h5>
                                </td>
                                <td class="padding" valign="top" style="padding-left: 15px;">
                                    <h5 style="font-size: 14px; color:#444;margin-top:15px">
                                        <b>{{ $product->pivot->product_price . $order->country->currency }}</b>
                                    </h5>
                                </td>
                            </tr>
                        @endforeach






                        <tr>
                            <td class="padding text-align" colspan="2"
                                style="line-height: 49px;font-size: 13px;color: #000000;padding-left: 20px;text-align:left;border-right: unset;">
                                {{ __('subtotal') }}</td>
                            <td class="padding" colspan="3" class="price"
                                style="line-height: 49px;text-align: right;padding-right: 28px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                <b>{{ $order->subtotal_price . $order->country->currency }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="padding text-align" colspan="2"
                                style="line-height: 49px;font-size: 13px;color: #000000;padding-left: 20px;text-align:left;border-right: unset;">
                                {{ __('discount') }}</td>
                            <td class="padding" colspan="3" class="price"
                                style="line-height: 49px;text-align: right;padding-right: 28px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                <b>{{ $order->discount_amount . $order->country->currency }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="padding text-align" colspan="2"
                                style="line-height: 49px;font-family: Arial;font-size: 13px;color: #000000;padding-left: 20px;text-align:left;border-right: unset;">
                                {{ __('tax value') }} </td>
                            <td class="padding" colspan="3" class="price"
                                style="line-height: 49px;text-align: right;padding-right: 28px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                <b>{{ $order->total_tax . $order->country->currency }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="padding text-align" colspan="2"
                                style="line-height: 49px;font-size: 13px;color: #000000;
                                    padding-left: 20px;text-align:left;border-right: unset;">
                                {{ __('shipping') }}</td>
                            <td class="padding" colspan="3" class="price"
                                style="
                                        line-height: 49px;text-align: right;padding-right: 28px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                <b>{{ $order->shipping_amount . $order->country->currency }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="padding text-align" colspan="2"
                                style="line-height: 49px;font-size: 13px;color: #000000;
                                    padding-left: 20px;text-align:left;border-right: unset;">
                                {{ __('total') }}</td>
                            <td class="padding" colspan="3" class="price"
                                style="line-height: 49px;text-align: right;padding-right: 28px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                <b>{{ $order->total_price . $order->country->currency }}</b>
                            </td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0" border="0" align="left"
                        style="width: 100%;margin-top: 30px;    margin-bottom: 30px;">
                        <tbody>
                            <tr>
                                <td class="padding"
                                    style="font-size: 13px; font-weight: 400; color: #444444; letter-spacing: 0.2px;width: 50%;">
                                    <h5 class="text-align"
                                        style="font-size: 16px; font-weight: 500;color: #000; line-height: 16px; padding-bottom: 13px; border-bottom: 1px solid #e6e8eb; letter-spacing: -0.65px; margin-top:0; margin-bottom: 13px;">
                                        {{ __('SHIPPING ADDRESS') }}</h5>
                                    <p
                                        style="text-align: left;font-weight: normal; font-size: 14px; color: #000000;line-height: 21px;    margin-top: 0;">
                                    <ul class="order-detail">
                                        @if ($order->shipping_method_id == '2')
                                            <li>{{ __('Local Pickup') . ': ' }} {{ $order->branch_id }}</li>
                                        @else
                                            <li>{{ $order->phone }}
                                            </li>
                                            <li>{{ app()->getLocale() == 'ar' ? $order->country->name_ar : $order->country->name_en }}
                                            </li>
                                            <li>{{ app()->getLocale() == 'ar' ? $order->state->name_ar : $order->state->name_en }}
                                            </li>
                                            <li>{{ app()->getLocale() == 'ar' ? $order->city->name_ar : $order->city->name_en }}
                                            </li>
                                            @if ($order->block)
                                                <li> {{ __('Block:') . ' ' . $order->block }}</li>
                                            @endif
                                            @if ($order->address)
                                                <li>{{ __('Address:') . ' ' . $order->address }}</li>
                                            @endif
                                            @if ($order->avenue)
                                                <li>{{ __('Avenue:') . ' ' . $order->avenue }}</li>
                                            @endif
                                            @if ($order->house)
                                                <li>{{ __('House:') . ' ' . $order->house }}</li>
                                            @endif
                                        @endif
                                    </ul>

                                    </p>
                                </td>


                                <td width="57" height="25" class="user-info"><img
                                        src="{{ asset('e-assets/images/space.jpg') }}" alt=" " height="25"
                                        width="57"></td>


                            </tr>
                        </tbody>
                    </table>


                </td>
            </tr>
        </tbody>
    </table>

    @if ($type == 'user')


        <table class="main-bg-light text-center top-0" align="center" border="0" cellpadding="0"
            cellspacing="0" width="100%">
            <tr>
                <td style="padding: 30px;">
                    <div>
                        <h4 class="title" style="margin:0;text-align: center;">{{ __('Follow us') }}</h4>
                    </div>
                    <table border="0" cellpadding="0" cellspacing="0" class="footer-social-icon" align="center"
                        class="text-center" style="margin-top:20px;">
                        <tr>
                            @if (websiteSettingAr('footer_facebook'))
                                <td>
                                    <a href="{{ websiteSettingAr('footer_facebook') }}"><img
                                            src="{{ asset('e-assets/images/facebook.png') }}" alt=""></a>
                                </td>
                            @endif
                            @if (websiteSettingAr('footer_youtube'))
                                <td>
                                    <a href="{{ websiteSettingAr('footer_youtube') }}"><img
                                            src="{{ asset('e-assets/images/youtube.png') }}" alt=""></a>
                                </td>
                            @endif
                            @if (websiteSettingAr('footer_instagram'))
                                <td>
                                    <a href="{{ websiteSettingAr('footer_instagram') }}"><img
                                            src="{{ asset('e-assets/images/instagram.png') }}" alt=""></a>
                                </td>
                            @endif




                        </tr>
                    </table>
                    <div style="border-top: 1px solid #ddd; margin: 20px auto 0;"></div>
                    {{-- <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 20px auto 0;">
                    <tr>
                        <td>
                            <a href="#" style="font-size:13px">Want to change how you receive these emails?</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:13px; margin:0;"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#"
                                style="font-size:13px; margin:0;text-decoration: underline;">Unsubscribe</a>
                        </td>
                    </tr>
                </table> --}}
                </td>
            </tr>
        </table>

    @endif
</body>

</html>
