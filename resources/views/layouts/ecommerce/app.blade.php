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
    <title>{{ app()->getLocale() == 'ar' ? websiteSettingAr('website_title') : websiteSettingEn('website_title') }}
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
    <link rel="stylesheet" type="text/css" href="{{ asset('e-assets/css/vendors/font-awesome.css') }}">

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
        </style>
    @endif



    @if (websiteSettingData('primary_color') && websiteSettingData('secondary_color'))
        <style>
            .theme-color-27 {
                --theme-color: {{ websiteSettingAr('primary_color') }} !important;
                --theme-color2: {{ websiteSettingAr('secondary_color') }} !important;
            }
        </style>
    @endif






</head>


<body class="theme-color-27 {{ app()->getLocale() == 'ar' ? 'rtl' : '' }}">

    @include('layouts.ecommerce._header')

    @yield('content')

    @include('layouts.ecommerce._flash')

    @include('layouts.ecommerce._footer')

    @include('layouts.ecommerce._modal')

    @include('layouts.ecommerce._qModal')




    <!-- tap to top -->
    <div class="tap-top top-cls">
        <div>
            <i class="fa fa-angle-double-up"></i>
        </div>
    </div>
    <!-- tap to top end -->









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
    <script src="{{ asset('assets/js/ecommerce.js') }}"></script>







    {{-- <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('vendors/rater-js/index.js') }}"></script> --}}







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
            }, 5000);
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            $('.error-noty').addClass("show");
            setTimeout(function() {
                $('.error-noty').removeClass("show");
            }, 5000);
        </script>
    @endif





    @php
        session()->forget('success');
        session()->forget('error');
    @endphp

</body>

</html>
