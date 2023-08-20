<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>


    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="red-gulf.com">
    <link rel="icon" href="{{ asset(websiteSettingMedia('header_icon')) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset(websiteSettingMedia('header_icon')) }}" type="image/x-icon">


    @isset($product)
        <meta name='description' itemprop='description'
            content='{{ $product->seo_desc != null ? $product->seo_desc : $product->description_ar }}'>
        <meta name='keywords' content='{{ $product->seo_meta_tag }}'>
        <meta property="og:description"
            content="{{ $product->seo_desc != null ? $product->seo_desc : $product->description_ar }}">
        <meta property="og:title" content="{{ getName($product) }}">
        <meta property="og:type" content="product">
        <meta property="og:url"
            content="{{ route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]) }}">
        <meta property="og:site_name"
            content="{{ app()->getLocale() == 'ar' ? websiteSettingAr('website_title') : websiteSettingEn('website_title') }}">
        <meta property="og:image" content="{{ getProductImage($product) }}">
        <meta property="og:image" content="{{ getProductImage2($product) }}">
    @endisset



    <title>
        @isset($page_title)
            {{ __($page_title) }} |
        @endisset
        {{ app()->getLocale() == 'ar' ? websiteSettingAr('website_title') : websiteSettingEn('website_title') }}

    </title>

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Yellowtail&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('e-assets/css/vendors/font-awesome.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('e-assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('e-assets/css/vendors/slick-theme.css') }}">

    <!-- Animate icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('e-assets/css/vendors/animate.css') }}">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('e-assets/css/vendors/themify-icons.css') }}">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('e-assets/css/vendors/bootstrap.css') }}">

    <!-- Price range icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('e-assets/css/vendors/price-range.css') }}">

    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('e-assets/css/style.css') }}">


    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>





    @if (setting('hotjar_id'))
        <!-- Hotjar Tracking Code for https://yfbstore.com/ -->
        <script>
            (function(h, o, t, j, a, r) {
                h.hj = h.hj || function() {
                    (h.hj.q = h.hj.q || []).push(arguments)
                };
                h._hjSettings = {
                    hjid: {{ setting('hotjar_id') }},
                    hjsv: 6
                };
                a = o.getElementsByTagName('head')[0];
                r = o.createElement('script');
                r.async = 1;
                r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
                a.appendChild(r);
            })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
        </script>
    @endif




    @if (setting('snapchat_pixel_id'))
        <!-- Snap Pixel Code -->
        <script type='text/javascript'>
            (function(e, t, n) {
                if (e.snaptr) return;
                var a = e.snaptr = function() {
                    a.handleRequest ? a.handleRequest.apply(a, arguments) : a.queue.push(arguments)
                };
                a.queue = [];
                var s = 'script';
                r = t.createElement(s);
                r.async = !0;
                r.src = n;
                var u = t.getElementsByTagName(s)[0];
                u.parentNode.insertBefore(r, u);
            })(window, document,
                'https://sc-static.net/scevent.min.js');

            snaptr('init', '{{ setting('snapchat_pixel_id') }}', {
                // 'user_email': '_INSERT_USER_EMAIL_'
                'ip_address': '{{ request()->ip() }}'
            });

            snaptr('track', 'PAGE_VIEW');
        </script>
        <!-- End Snap Pixel Code -->
    @endif

    @if (setting('tiktok_id'))
        <script>
            ! function(w, d, t) {
                w.TiktokAnalyticsObject = t;
                var ttq = w[t] = w[t] || [];
                ttq.methods = ["page", "track", "identify", "instances", "debug", "on", "off", "once", "ready", "alias",
                    "group", "enableCookie", "disableCookie"
                ], ttq.setAndDefer = function(t, e) {
                    t[e] = function() {
                        t.push([e].concat(Array.prototype.slice.call(arguments, 0)))
                    }
                };
                for (var i = 0; i < ttq.methods.length; i++) ttq.setAndDefer(ttq, ttq.methods[i]);
                ttq.instance = function(t) {
                    for (var e = ttq._i[t] || [], n = 0; n < ttq.methods.length; n++) ttq.setAndDefer(e, ttq.methods[n]);
                    return e
                }, ttq.load = function(e, n) {
                    var i = "https://analytics.tiktok.com/i18n/pixel/events.js";
                    ttq._i = ttq._i || {}, ttq._i[e] = [], ttq._i[e]._u = i, ttq._t = ttq._t || {}, ttq._t[e] = +new Date,
                        ttq._o = ttq._o || {}, ttq._o[e] = n || {};
                    var o = document.createElement("script");
                    o.type = "text/javascript", o.async = !0, o.src = i + "?sdkid=" + e + "&lib=" + t;
                    var a = document.getElementsByTagName("script")[0];
                    a.parentNode.insertBefore(o, a)
                };

                ttq.load('{{ setting('tiktok_id') }}');
                ttq.page();
            }(window, document, 'ttq');
        </script>
    @endif


    @if (setting('google_analytics_id'))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('google_analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '{{ setting('google_analytics_id') }}');
        </script>
    @endif


    @if (setting('facebook_id'))
        <!-- Facebook Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ setting('facebook_id') }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={your-pixel-id-goes-here}&ev=PageView&noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->
    @endif


    @if (setting('tagmanager_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-B4QJRZ19MH"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '{{ setting('tagmanager_id') }}');
        </script>
    @endif




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

            .breadcrumb-item+.breadcrumb-item::before {
                float: right;
            }

            .flash-news {
                direction: rtl !important;
            }

            .main-menu .menu-right .icon-nav .onhover-div .show-div.shopping-cart li .total h5 span {
                float: left;
            }

            .main-menu .menu-right .icon-nav .onhover-div .show-div.shopping-cart li .total h5 {
                text-align: right;
            }

            .product-box .product-detail h6,
            .product-box .product-info h6,
            .product-wrap .product-detail h6,
            .product-wrap .product-info h6 {
                direction: rtl;
            }

            .theme-card .offer-slider .media .media-body a h6 {
                direction: rtl;
            }

            .timer {
                direction: ltr !important;
                margin-right: 10px
            }

            .padding-l {
                padding-left: 10px !important;
            }



            body.rtl .timer {
                float: none;
            }
        </style>
    @endif

    @php
        $primary_color = websiteSettingAr('primary_color') ? websiteSettingAr('primary_color') : '#e83837';
        $secondry_color = websiteSettingAr('secondary_color') ? websiteSettingAr('secondary_color') : '#1d1d1b';
    @endphp


    <style>
        .theme-color-27 {
            --theme-color: {{ $primary_color }} !important;
            --theme-color2: {{ $secondry_color }} !important;
        }

        .theme-card .offer-slider .media .media-body a h6 {
            white-space: nowrap;
            overflow: hidden;
            width: 150px;
            text-overflow: ellipsis;
        }

        .pixelstrap ul {
            background-color: {{ $secondry_color }} !important;
        }

        .pixelstrap ul li a {
            color: #ffffff !important;
        }

        .add-btn a {
            color: var(--theme-color);
        }

        .text-300 {
            color: #999999;
        }

        .product-box .cart-detail i,
        .product-wrap .cart-detail i {
            color: {{ $primary_color }} !important;
        }

        .product-box .cart-info.cart-wrap i,
        .product-box .cart-wrap.cart-wrap i,
        .product-wrap .cart-info.cart-wrap i,
        .product-wrap .cart-wrap.cart-wrap i {
            color: {{ $primary_color }} !important;

        }

        .btn-category {
            background-color: {{ $primary_color }} !important;
            border-color: {{ $primary_color }} !important;
        }

        .badge-grey-color {
            background-color: {{ $primary_color }} !important;

        }

        .primary-color {
            color: {{ $primary_color }} !important;
        }

        .color-selector-custome {
            height: 30px;
            width: 30px;
            border-radius: 50%;
            margin-right: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            border: 1px solid #444444;
        }

        .header-logo {
            width: 140px;
        }

        .icon-item {
            padding: 5px;
        }

        .fa-shopping-cart {
            font-size: 17px !important;
        }

        .btn-solid {
            margin-top: 2px;
            padding: 7px 15px !important;
        }

        .product-right .color-variant li.active {
            border: 3px solid {{ $primary_color }};
        }

        .color-variant li {
            border: 1px solid {{ $primary_color }};
        }

        .coupon-link {
            color: {{ $primary_color }};
        }

        .coupon-text {
            color: {{ $primary_color }};

        }

        .coupon-text-green {
            color: rgb(26, 106, 26) !important;
        }

        .float {
            position: fixed;
            width: 47px;
            height: 47px;
            bottom: 70px;
            right: 31px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .float:hover {
            background-color: #25d366;
            color: #FFF;
        }

        .my-float {
            margin-top: 10px;
        }

        .rtl .top-header .header-dropdown>li:nth-child(2) {
            padding: 10px 15px;
            padding-left: 8px;
        }

        .rating i:last-child {
            color: #ffa200;
        }

        .box-selector ul li {
            width: unset !important;
            height: unset !important;
            border-radius: unset !important;
            padding: 5px !important;
            font-size: 12px !important;
            margin-bottom: 1px !important;
            border: 2px solid #ddd !important;
        }

        .box-selector ul li:hover {
            border: 2px solid {{ $primary_color }} !important;
        }

        .box-selector ul li.active {
            border: 2px solid {{ $primary_color }} !important;
        }

        .box-selector ul li.active:after {
            display: none !important;
        }

        .full-box .theme-card .offer-slider .product-box2 {
            padding: 10px;
        }

        @media (min-width: 577px) {

            .header-style-5.color-style .top-header .header-dropdown>li {
                padding: 30px 12px;
                padding-right: 0;
            }
        }

        .rtl .main-menu .menu-right .icon-nav li {
            padding-left: 0;
            padding-right: 15px;
        }



        @media (max-width: 577px) {


            .float {
                position: fixed;
                width: 40px;
                height: 40px;
                bottom: 70px;
                right: 19px;
                background-color: #25d366;
                color: #FFF;
                border-radius: 50px;
                text-align: center;
                font-size: 30px;
                box-shadow: 2px 2px 3px #999;
                z-index: 100;
            }



            .my-float {
                margin-top: 6px;
            }

            .main-menu .menu-right .icon-nav .mobile-search {
                right: 83%;
                z-index: 1;
            }

            .top-header .header-dropdown .mobile-wishlist {
                right: 72%;
            }

            .rtl .main-menu .menu-right .icon-nav .mobile-cart {
                right: unset;
                left: 38%;
            }

            .main-menu .menu-right .icon-nav .mobile-cart {

                right: 57%;

            }

            .top-header .header-dropdown .mobile-account {
                position: fixed;
                bottom: 20px;
                right: 41%;
                font-size: 0;
                padding: 0;
                z-index: 9;
            }

            .main-menu .menu-right .icon-nav .mobile-setting {
                position: fixed;
                bottom: 20px;
                right: 23%;
                font-size: 0;
                padding: 0;
            }

            .mobile-home {
                right: 10% !important;
            }

            .height-65 .home .slider-contain {
                height: 30vh !important;
            }

            .height-65 .home .slider-contain h1 {
                font-size: 20px !important;
            }

            .height-65 .home .slider-contain h4 {
                font-size: 14px !important;
            }

            .height-65 .home {
                height: 30vh !important;
            }
        }


        .footer-title span {
            font-family: 'FontAwesome' !important;
        }

        .ratio_asos .bg-size:before {
            padding-top: 100%;
            content: "";
            display: block;
        }

        @media screen and (max-width: 600px) {
            .header-logo {
                width: 80px;
                height: 84px !important;
            }
        }
    </style>









</head>


<body class="theme-color-27 {{ app()->getLocale() == 'ar' ? 'rtl' : '' }}">




    @include('layouts.ecommerce._header')

    @yield('content')




    @include('layouts.ecommerce._flash')

    @include('layouts.ecommerce._footer')


    @include('layouts.ecommerce._qModal')




    <!-- tap to top -->
    <div class="tap-top top-cls">
        <div>
            <i class="fa fa-angle-double-up"></i>
        </div>
    </div>
    <!-- tap to top end -->

    @if (websiteSettingAr('whatsapp_check'))
        {!! getWhatsappButton() !!}
    @endif



    <!-- latest jquery-->
    <script src="{{ asset('e-assets/js/jquery-3.3.1.min.js') }}"></script>

    <!-- slick js-->
    <script src="{{ asset('e-assets/js/slick.js') }}"></script>
    <script src="{{ asset('e-assets/js/slick-animation.min.js') }}"></script>

    <!-- menu js-->
    <script src="{{ asset('e-assets/js/menu.js') }}"></script>
    <script src="{{ asset('e-assets/js/sticky-menu.js') }}"></script>

    <!-- ajax search js -->
    <script src="{{ asset('e-assets/js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('e-assets/js/typeahead.jquery.min.js') }}"></script>
    <script src="{{ asset('e-assets/js/ajax-custom.js') }}"></script>

    <!-- lazyload js-->
    <script src="{{ asset('e-assets/js/lazysizes.min.js') }}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('e-assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Bootstrap Notification js-->
    <script src="{{ asset('e-assets/js/bootstrap-notify.min.js') }}"></script>


    <!-- price range js -->
    <script src="{{ asset('e-assets/js/price-range.js') }}"></script>



    <!-- Theme js-->
    <script src="{{ asset('e-assets/js/theme-setting.js') }}"></script>
    <script src="{{ asset('e-assets/js/script.js') }}"></script>
    <script src="{{ asset('e-assets/js/color-setting.js') }}"></script>
    <script src="{{ asset('e-assets/js/custom-slick-animated.js') }}"></script>
    <!-- Timer js-->
    <script src="{{ asset('e-assets/js/timer.js') }}"></script>
    <script src="{{ asset('assets/js/ecommerce.js') }}"></script>

    @if (Route::is('ecommerce.checkout') || Route::is('ecommerce.product'))
        <script src="{{ asset('assets/js/checkout.js') }}"></script>
    @endif





    @if (Route::is('ecommerce.account'))
        <script src="{{ asset('vendors/rater-js/index.js') }}"></script>


        <script>
            const elements = document.querySelectorAll('.rate');
            elements.forEach((element) => {
                var starRatingStep = raterJs({
                    starSize: 32,
                    step: 0.5,
                    element: element,
                    rateCallback: function rateCallback(rating, done) {
                        this.setRating(rating);
                        done();
                    }
                });
            });
        </script>
    @endif


    @if (Route::is('ecommerce.product'))
        <script src="{{ asset('vendors/rater-js/index.js') }}"></script>
        <script>
            var starRatingStep = raterJs({
                starSize: 32,
                step: 0.5,
                element: document.querySelector("#rate"),
                rateCallback: function rateCallback(rating, done) {
                    this.setRating(rating);
                    done();
                }
            });
        </script>
    @endif






    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


    @if (session()->has('success'))
        <script>
            $('.success-noty').addClass("show");
            setTimeout(function() {
                $('.success-noty').removeClass("show");
            }, 10000);
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            $('.error-noty').addClass("show");
            setTimeout(function() {
                $('.error-noty').removeClass("show");
            }, 10000);
        </script>
    @endif



    @if (websiteSettingAr('check_front_popup') == 'on' || websiteSettingAr('check_front_auth_popup') == 'on')
        <script>
            $(window).on('load', function() {
                setTimeout(function() {
                    $('#exampleModal').modal('show');
                }, 2500);

                setTimeout(function() {
                    $('#exampleModal').modal('hide');
                }, 15000);
            });
        </script>
    @endif






    @php
        session()->forget('success');
        session()->forget('error');
    @endphp

</body>

</html>
