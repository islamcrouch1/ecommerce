<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>



    <!-- Metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="keywords" content="HTML5 Template Iteck Multi-Purpose themeforest" />
    <meta name="description" content="Iteck - Multi-Purpose HTML5 Template" />
    <meta name="author" content="" />

    <!-- Title  -->
    <title>Elkomy Group</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/fevicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/fevicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/fevicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/fevicon.png') }}">
    <link rel="manifest" href="{{ asset('/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/fevicon.png') }}">
    <meta name="theme-color" content="#ffffff">


    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('common/assets/css/lib/bootstrap.min.css') }}">

    <!-- font family -->
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- fontawesome icons  -->
    <link rel="stylesheet" href="{{ asset('common/assets/css/lib/all.min.css') }}">
    <!-- ionicons icons  -->
    <link rel="stylesheet" href="{{ asset('common/assets/css/lib/ionicons.css') }}">
    <!-- animate css  -->
    <link rel="stylesheet" href="{{ asset('common/assets/css/lib/animate.css') }}" />
    <!-- fancybox popup  -->
    <link rel="stylesheet" href="{{ asset('common/assets/css/lib/jquery.fancybox.css') }}" />
    <!-- lity popup  -->
    <link rel="stylesheet" href="{{ asset('common/assets/css/lib/lity.css') }}" />
    <!-- swiper slider  -->
    <link rel="stylesheet" href="{{ asset('common/assets/css/lib/swiper8.min.css') }}" />

    <!-- common style -->
    <link rel="stylesheet" href="{{ asset('common/assets/css/common_style.css') }}" />

    <!-- home style -->
    <link rel="stylesheet" href="{{ asset('assets/css/home_24_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/inner_pages_style.css') }}" />




    @if (app()->getLocale() == 'ar')
        <script>
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        </script>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap');

            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            p,
            a,
            span {
                font-family: 'Cairo' !important;
            }

            body {
                direction: rtl;
            }

            .tc-header-style39 .img {
                margin-right: -65%;
            }

            .tc-projects-style39 {
                padding-right: calc((100vw - 1330px) / 2);
                padding-left: 0;

            }

            .button_su {
                padding-left: 10px
            }
        </style>
    @else
        <script>
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        </script>
    @endif

    <style>
        .tc-header-style39 {
            min-height: 0px;
        }

        .br-10 {
            border-radius: 10px;
            margin-top: 10px;
        }

        .tc-header-style39 .info h1 {
            font-size: 80px;
            margin-bottom: 20px;
        }

        .tc-footer-style39 {
            position: relative;
            background-color: #04010b;
            color: #fff;
        }

        .bg-cyan1 {
            background: #ffffff !important;
            border-color: #04010b !important;
        }

        .page-contact-style3 .conatct-form {
            background-color: var(--color-blue6);
            border-radius: 30px;
            color: #fff;
        }

        /* .butn span {
            color: #04010b !important;
            font-weight: 500;
        } */

        .lab {
            font-family: 'Line Awesome Brands' !important;
        }

        :root {
            --color-blue6: #04010b !important;
        }

        .gold {
            color: #bb975e !important;
        }

        .black {
            color: #04010b !important;
        }

        .b-gold {
            background-color: #bb975e !important;
            border-color: #bb975e !important;

        }

        .tc-services-style39 .service-card {
            padding: 40px !important;
        }

        .service-card .info p {
            min-height: 140px;
        }

        .text-uppercase {
            font-size: 15px !important;
        }

        .tc-header-style10 {
            padding: 50px 0 150px;
            background-color: var(--color-blue6);
        }

        .tc-header-style10::before {
            background-color: var(--color-blue6);

        }

        .logo {
            background-color: var(--color-blue6);
            padding: 10px;
            border-radius: 10px;
        }

        .page-about .tc-page-about-numbers {
            background-image: url({{ asset('/assets/img/elkomy/numbers_back.png') }});
        }

        .page-about .tc-page-about-timeline {
            padding-top: 0;
        }

        .page-faq .tc-page-faq .accordion .accordion-item .accordion-button.accordion-button:not(.collapsed) {
            color: #fff;
            background-color: #bb975e;
            border-color: var(--color-blue6);
        }

        .home-style10 .tc-portfolio-style25 .portfolio-content .content .portfolio-card .info::before {
            background-color: #bb975e;
        }

        .ltr {
            direction: ltr !important
        }
    </style>

</head>



@include('layouts.front._header')


<body
    class="{{ app()->getLocale() == 'ar' ? 'home-style24-rtl' : 'home-style24 ' }} home-style10 f-fm-jakarta page-services-details page-about page-faq inner-pages   home-style3 page-contact-style3 home-style11">


    @yield('contentFront')

    @include('layouts.front._footer')




    <!--  request  -->
    <script src="{{ asset('common/assets/js/lib/jquery-3.0.0.min.js') }}"></script>
    <script src="{{ asset('common/assets/js/lib/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('common/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('common/assets/js/lib/wow.min.js') }}"></script>
    <script src="{{ asset('common/assets/js/lib/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('common/assets/js/lib/lity.js') }}"></script>
    <script src="{{ asset('common/assets/js/lib/swiper8-bundle.min.js') }}"></script>
    <script src="{{ asset('common/assets/js/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('common/assets/js/lib/jquery.counterup.js') }}"></script>
    <script src="{{ asset('common/assets/js/lib/parallaxie.js') }}"></script>

    <!-- ----- home scripts ----- -->
    <script src="{{ asset('assets/js/home_24_scripts.js') }}"></script>
    <script src="{{ asset('assets/js/inner_pages_scripts.js') }}"></script>



    <script>
        const myCarouselElement = document.querySelector('#home-carousel')

        const carousel = new bootstrap.Carousel(myCarouselElement, {
            interval: 3000,
        })
    </script>


</body>

</html>
